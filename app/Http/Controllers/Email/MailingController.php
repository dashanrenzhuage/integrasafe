<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

/**
 * Laravel Classes
 */
use App\Classes\DataObject;
use App\Classes\DisplayGroups;
use App\Classes\QueryBuilder;
use App\Classes\Validation;
use App\Http\Controllers\Controller;
use App\Mail\Subscribe;
use App\Orders;
use App\Subscriptions;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Mail as Email;
use Mockery\Exception;
use Session;

/**
 * Class SubscriptionController
 * @package App\Http\Controllers
 */
class MailingController extends Controller
{
    /**
     * @var array|\Illuminate\Http\Request|null|string
     */
    public $request = null;
    /**
     * @var null|\stdClass
     */
    public $dataObject = null;

    // String Constants
    public $pcb_emails = 'pcb_emails';
    public $string_email = 'email';
    public $menu_type = 'menu_type';
    public $cart_item = 'cart_item';

    /**
     * Public function __construct, to construct and display the data object
     *
     * SubscriptionController constructor.
     */
    public function __construct()
    {
        $this->middleware('domain');
        $this->request = request();

        $data_object = new DataObject($this->request);
        $this->dataObject = $data_object->fetch();
    }

    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {
        $validation = new Validation();
        $query_builder = new QueryBuilder();
        $display_groups = new DisplayGroups();

        $created_data = $this->dataObject;

        $errors = $validation->subscribe($created_data->form);
//        if ($errors->fails()) {
//            return redirect()->back()->withErrors($errors)->withInput();
//        }

        $return = [];
        if (!empty($created_data->form['zip-postal-code'])) {
            $return[] = $validation->zipCode($created_data->form['zip-postal-code']);
        }
        if (!empty($created_data->form['phone-number'])) {
            $return[] = $validation->telephoneNumber($created_data->form['phone-number']);
        }

        if (!in_array(false, $return)) {

            $order = Orders::select('instant_quote', 'full_quote', 'subscription')
                ->where('ip', $created_data->ip)
                ->first();

            //if order already exists then update the current row, else make a new row.
            if ($order) {
                if (!$order['subscription']) {
                    $query_builder->inject('subscribe', $created_data);
                }
            } else {
                $query_builder->inject('subscribe_simple', $created_data);
            }

            // If they have registered Account in our DB, we need to Update their metadata row to show the change
            try {
                $subscription = Subscriptions::select($this->pcb_emails)
                    ->where($this->string_email, $created_data->form[$this->string_email])
                    ->first();

                if ($subscription) {

                    if ($subscription[$this->pcb_emails] !== 'Yes' || $subscription[$this->pcb_emails] !== 'yes') {
                        $query_builder->resubscribePCB($created_data->form[$this->string_email]);
                    }
                } else {
                    $query_builder->subscribePCB($created_data->form[$this->string_email]);
                }
            } catch (Exception $except) {
                // If the person subscribing doesn't have an Account, do nothing
            }


            $env = new DotenvEditor();
            if ($env->getValue('APP_ENV') === "production") {
                //Send them an Email thanking them for Subscribing
                Email::to($created_data->form[$this->string_email])->send(new Subscribe($created_data->form, 'from@custompcb.net'));
            }

            return view('pcb.subscribed', [
                $this->menu_type => 'pcb',
                $this->cart_item => 'cart-highlight',
                'flow' => $display_groups->flow('Account')
            ]);
        }

        return '<div class="error">' . Session::get('error')[0] . '</div>';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error()
    {
        $display_groups = new DisplayGroups();

        return view('pcb.error', [
            $this->menu_type => 'pcb',
            $this->cart_item => '',
            'flow' => $display_groups->flow('Info')
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscribe()
    {
        $display_group = new DisplayGroups();

//        return view('emails.subscribe');
        return view('pcb.error', [
            $this->menu_type => 'pcb',
            $this->cart_item => 'cart-highlight',
            'request' => $this->request,
            'flow' => $display_group->flow('Info')
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unsubscribePCB()
    {
        $query_builder = new QueryBuilder();
        // get Email

        $query_builder->unsubscribePCB($email);

        return view('emails.unsubscribe');
    }
}

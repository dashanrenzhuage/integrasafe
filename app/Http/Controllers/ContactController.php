<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Classes\Validation;
use App\Comments;
use App\Mail\Mail as Mail;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as Email;
use Redirect;
use Session;

/**
 * Class Contact
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{
    // String Constants
    public $string_email = 'email';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showContact()
    {
        return view('documents.contact');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        $create_data = $request->all();

        $full_name = $create_data['name'];
        $email = $create_data[$this->string_email];
        $feedback = $create_data['contact'];

        $validation = new Validation();

        $return = [
            $validation->long($full_name, 50, 'First name', false),
            $validation->long($feedback, 1000, 'feedback', true),
            $validation->email($email, 50, 'Email', true),
        ];

        if (!in_array(false, $return)) {
            $error = null;
            $create_date = date('Y-m-d h:i:s');
            $result = Comments::where('name', $full_name)
                ->where($this->string_email, $email)
                                ->orderBy('id', 'desc')
                ->first();

            if ($result) {

                $created_at = strtotime($result['attributes']['created_at']);

                if (($created_at - time()) < 300 &&
                    $result['attributes'][$this->string_email] === $email) {
                    $error = 'Too many feedback attempts, please slow down';
                }
            }

            if (isset($full_name, $email, $feedback) && empty($error)) {
                Comments::insert(['app' => 'Contact',
                                  'name' => $full_name,
                    $this->string_email => $email,
                                  'feedback' => $feedback,
                                  'ip' => $request->ip(),
                                  'created_at' => $create_date]);
            }

            $env = new DotenvEditor();
            if ($env->getValue('APP_ENV') === "production") {
                //Send them an Email thanking them for Contacting Us
                $message = new Mail($create_data, 'contact');
                Email::to($email)->send($message);
            }

            Session::flash('message', "Your message will be reviewed, thank you!");
        }

        return Redirect::back();
    }

    /**
     * Access the Social Networks page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function social()
    {
        $document = __('message.social');

        return view('documents.social', [
            'cart_item' => '',
            'document' => $document
        ]);
    }
    /**
     * glossary()
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function glossary()
    {
        return view('documents.glossary', ['cart_item' => '']);
    }
}

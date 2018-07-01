<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Accounts;
use App\Classes\Validation;
use App\Comments;
use App\Mail\Feedback;
use App\Roles;
use App\Users;
use Auth;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail as Email;
use Redirect;
use Request;
use Session;

/* Custom classes */

/* Modals */

/**
 * Class MultiController
 * @package App\Http\Controllers
 */
class MultiController extends Controller
{
    // String Literals
    public $admin = 'admin';
    public $manager = 'manager';
    public $string_email = 'email';
    public $unauthorized = 'Unauthorized.';
    public $pass = 'password';
    public $created_at = 'created_at';
    public $forbidden = 'Forbidden.';
    public $account_route = '/account/';

    /**
     * MultiController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'index', 'create', 'store', 'destroy', $this->admin, 'unadmin'
        ]]);
        $this->middleware('domain');
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool
     */
    public function index()
    {
        return false;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole($this->manager) || Auth::user()->hasRole($this->admin)) {
            return view('auth.create');
        } else {
            return response($this->unauthorized, 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::user()->hasRole($this->manager) && !Auth::user()->hasRole($this->admin)) {
            return response($this->unauthorized, 401);
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            $this->string_email => 'required|email|max:255|unique:multi.users',
            $this->pass => 'required|confirmed|min:6'
        ]);

        $create_data = $request->all();
        $account_id = Auth::user()->account_id;

        $create_user = Users::create([
            'name' => $create_data['name'],
            $this->string_email => $create_data[$this->string_email],
            $this->pass => bcrypt($create_data[$this->pass]),
            'account_id' => $account_id,
            $this->created_at => date("Y-m-d h:i:sa"),
        ]);

        if (array_key_exists('is_manager', $create_data)) {
            // set manager in Roles if button was selected
            $create_role = Roles::whereName($this->manager)->first();
            $create_user->assignRole($create_role);
        }

        return redirect($this->account_route . Auth::user()->account_id);
    }

    /**
     * Feedback
     *
     * Insert feedback into database, and email the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function feedback(Request $request)
    {
        $throttle = false;
        $validation = new Validation('feedback-error');

        $return = [
            $validation->long(50, 'First name', $request->name, false),
            $validation->email(50, 'Email', $request->email, false),
            $validation->long(1000, 'feedback', $request->feedback, true),
        ];

        if (!in_array(false, $return)) {

            $comment = Comments::select($this->created_at, $this->string_email)
                ->where('name', $request->name)
                ->where($this->string_email, $request->email)
                ->orderBy('id', 'desc')
                ->first();

            $header = 'Your feedback will be used to create a better experience, thank you!';

            if ($comment) {
                $time_difference = strtotime(date('Y-m-d h:i:s')) - strtotime($comment[$this->created_at]->toDateTimeString());

                if ($time_difference < 300 && $comment[$this->string_email] === $request->email) {
                    $header = 'Too many feedback attempts, please slow down';
                    $throttle = true;
                }
            }

            $first_name = (!$request->name) ? null : $request->name;
            $email = (!$request->email) ? null : $request->name;

            //Throttle the request if too many attempts.
            if (!$throttle) {
                Comments::insert([
                    'app' => $request->session()->get('renderer')->domain,
                    'name' => $first_name,
                    $this->string_email => $email,
                    'feedback' => $request->feedback,
                    'ip' => $request->ip()
                ]);

                if (isset($request->email)) {
                    $env = new DotenvEditor();
                    // Check ENV as to not send an actual email in testing
                    if ($env->getValue('APP_ENV') === "production") {
                        Email::to($request->email)->send(new Feedback($request->all(), 'from@' . Session::get('renderer')->domain . '.net'));
                    }
                }
            }

            Session::flash('message', $header);
        }

        return Redirect::back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function feedbackForm()
    {
        return view('pcb.feedback');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $create_user = Auth::user();
        $target = Users::find($id);
        $account = Accounts::find($create_user->account_id);
        if (($target->account_id == $create_user->account_id) && ($create_user->hasRole($this->manager) || $create_user->hasRole($this->admin))) {
            if ($account->primary_user_id == $target->id) {
                return response('Cannot delete the primary account user.', 403);
            }
            // You don't want an Admin to be able to COMPLETELY destroy an entire User.
            // Instead, keep the user's data in the User-Auth database but remove the account_id
            // that is associating them with the Company account.
            $target->update([
                'account_id' => null,
            ]);

            return redirect($this->account_route . $create_user->account_id);
        }

        return response($this->unauthorized, 401);
    }

    /**
     * @param int $id
     * @return Response/Redirect
     */
    public function admin(int $id)
    {
        $create_user = Auth::user();
        if (!$create_user->hasRole($this->admin)) {
            return response($this->Forbidden, 403);
        }
        $target = Users::find($id);
        // 2 stands for admin in the Roles table
        $target->assignRole('2');
        $target->save();

        return redirect($this->account_route . $create_user->account_id);
    }

    /**
     * @param int $id
     * @return Response/Redirect
     */
    public function unadmin(int $id)
    {
        $create_user = Auth::user();
        if (!$create_user->hasRole($this->admin)) {
            return response($this->Forbidden, 403);
        }
        $target = Users::find($id);

        if ($target->hasRole($this->admin)) {
            $target->removeRole('2');
        }
        $target->save();

        return redirect($this->account_route . $create_user->account_id);
    }


    /**
     * @param int $id
     * @return Response/Redirect
     */
    public function impersonate(int $id)
    {
        if (!Auth::user()->hasRole($this->admin)) {
            return response($this->Forbidden, 403);
        }
        Auth::login(Users::find($id));
        return redirect('/');
    }

    /**
     * @param int $id
     * @return Response/Redirect
     */
    public function manager(int $id)
    {
        $create_user = Auth::user();
        if (!$create_user->hasRole($this->admin)) {
            return response($this->Forbidden, 403);
        }
        $target = Users::find($id);

        // 3 stands for manager in the Roles table
        $target->assignRole('3');
        $target->save();

        return redirect($this->account_route . $create_user->account_id);
    }

    /**
     * @param int $id
     * @return Response/Redirect
     */
    public function unmanager(int $id)
    {
        $create_user = Auth::user();
        if (!$create_user->hasRole($this->admin)) {
            return response($this->Forbidden, 403);
        }
        $target = Users::find($id);

        if ($target->hasRole($this->manager)) {
            $target->removeRole('3');
        }
        $target->save();

        return redirect($this->account_route . $create_user->account_id);
    }
}

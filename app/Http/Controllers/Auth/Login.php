<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class Login
 * @package App\Http\Controllers\Auth
 */
class Login extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Auth guard
     *
     * @var
     */
    protected $auth;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    // String Constants
    public $email = 'email';
    public $pass = 'password';

    /**
     * Create a new controller instance.
     *
     * LoginController constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->auth = $auth;
    }

    /**
     * TITLE
     *
     * DESC/SUMMARY
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @internal param $
     *
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * TITLE
     *
     * DESC/SUMMARY
     *
     * @param array $data
     * @return \Illuminate\Validation\Validator
     * @internal param $
     *
     */
    public function validator(array $data)
    {
        return Validator::make($data,
            [
                $this->email => 'required|email|max:255',
                $this->pass => 'required|min:6|max:20',
            ],
            [
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'email.max'             => 'Email is maximum length is 255 characters',
                'email.min'             => 'Email needs to have at lest 5 characters',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
            ]
        );
    }

    /**
     * TITLE
     *
     * DESC/SUMMARY
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @internal param $
     *
     */
    public function login(Request $request)
    {
        $email = $request->get($this->email);
        $password = $request->get($this->pass);
        // $remember   = $request->get('remember');

        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($this->auth->attempt([$this->email => $email, $this->pass => $password])) {
            return redirect('/');

        } else {

            return redirect()->back()
                ->with('message', 'Incorrect email or password')
                ->with('status', 'danger')
                ->withInput();
        }

    }
}

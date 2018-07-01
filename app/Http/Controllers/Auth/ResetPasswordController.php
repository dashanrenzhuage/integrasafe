<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Request;
use Users;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $connection = 'multi';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Show the reset password form

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('auth.passwords.reset');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reset(Request $request)
    {
        // validation goes here...

        $data = $request->all();

        // TODO ---> insert new entry in the password_reset table
        // DB::connection('multi')->insert('INSERT INTO password_resets (email) VALUES ('.$data["email"].'');

        Users::where('email', $data['email'])
                ->update(['password' => bcrypt($data['password']) ]);

        return redirect('/login');
    }
}

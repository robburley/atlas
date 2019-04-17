<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\LogInAttempt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Which column to authenticate users by.
     *
     * @var string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->failedLogInAttempt($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($this->guard()->user()->active) {
                $this->successfulLogInAttempt($request, $this->guard()->user());

                return $this->sendLoginResponse($request);
            }

            $this->guard()->logout();

            $request->session()->flush();

            $request->session()->regenerate();
        }

        $this->failedLogInAttempt($request);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function failedLogInAttempt($request)
    {
        LogInAttempt::create([
            'username'   => $request->get('username'),
            'ip_address' => $request->server('REMOTE_ADDR'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'outcome'    => 0,
        ]);
    }

    public function successfulLogInAttempt($request, $user)
    {
        LogInAttempt::create([
            'user_id'    => $user->id,
            'ip_address' => $request->server('REMOTE_ADDR'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'outcome'    => 1,
        ]);
    }
}

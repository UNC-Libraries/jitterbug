<?php

namespace Jitterbug\Http\Controllers\Auth;

use Adldap\Auth\BindException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Jitterbug\Http\Controllers\Controller;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        logout as doLogout;
        login as traitLogin;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(Request $request)
    {
        $this->doLogout($request);

        return redirect('/login?logout=true');
    }

    public function login(Request $request)
    {
        try {
            return $this->traitLogin($request);
        } catch (BindException $e) {
            //
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
      ->withInput($request->only($this->username(), 'remember'))
      ->withErrors([
          'failedLogin' => 'Invalid Onyen or Password',
      ]);
    }

    /**
     * Default to authenticate with username
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}

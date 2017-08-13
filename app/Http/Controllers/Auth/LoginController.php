<?php namespace Jitterbug\Http\Controllers\Auth;

use Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\User;

class LoginController extends Controller
{
  use AuthenticatesUsers {
    logout as doLogout;
  }

  /**
   * Where to redirect users after login / registration.
   *
   * @var string
   */
  protected $redirectTo = '/dashboard';

  /**
   * Where to redirect users after logout.
   *
   * @var string
   */
  protected $redirectAfterLogout = '/login?logout=true';

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

  /**
   * Get the failed login response instance.
   *
   * @param \Illuminate\Http\Request  $request
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
  public function username() {
    return 'username';
  }

}
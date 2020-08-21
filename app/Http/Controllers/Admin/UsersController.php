<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\User;

class UsersController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
  }

  public function index(Request $request) {
    if ($request->ajax()) {
      $records = User::hasLoggedIn()->get();
      return view('admin._users', compact('records'));
    }
  }

  public function inactivate() {

  }
}
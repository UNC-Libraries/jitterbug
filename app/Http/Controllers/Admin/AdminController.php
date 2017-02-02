<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\User;

class AdminController extends Controller
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
  
  public function index()
  {
    return view('admin.index');
  }

  public function makeAdmin(Request $request)
  {
    if ($request->ajax()) {
      $input = $request->all();
      $username = $input['username'];
      $user = User::where('username', $username)->first();
      $user->admin = 1;
      $user->save();
    }
  }

  public function removeAdmin(Request $request)
  {
    if ($request->ajax()) {
      $input = $request->all();
      $username = $input['username'];
      $user = User::where('username', $username)->first();
      $user->admin = 0;
      $user->save();
    }
  }

}

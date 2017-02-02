<?php namespace Jitterbug\Http\Controllers;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;

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

  public function recordsForTable(Request $request)
  {
    if ($request->ajax()) {
      $table = $request->query('table');
      
      $records = null;
      if ($table === 'users') {
        $records = User::hasLoggedIn()->get();
      } else {
        $records = DB::table($table)->get();
      }

      $partial = 'admin._' . str_replace('_', '-', $table);
      return view($partial, compact('records'));
    }
  }
}
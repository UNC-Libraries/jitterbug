<?php namespace Jitterbug\Http\Controllers;

use Auth;
use Log;

use Illuminate\Http\Request;

use Jitterbug\Models\AudioVisualItemType;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PreservationMasterType;
use Jitterbug\Models\TransferType;
use Jitterbug\Models\User;
use Jitterbug\Presenters\ActivityStream;
use Jitterbug\Presenters\DashboardMark;
use Jitterbug\Presenters\TypeCounts;

class AdminController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  
  public function index()
  {
    return view('admin.index');
  }

}
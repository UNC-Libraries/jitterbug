<?php namespace Jitterbug\Http\Controllers;

use Log;

use Jitterbug\Models\AudioVisualItemType;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PreservationMasterType;
use Jitterbug\Models\TransferType;
use Jitterbug\Presenters\TypeCounts;
use Jitterbug\Presenters\ActivityStream;

class DashboardController extends Controller
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
    // Overview counts
    $itemCounts = new TypeCounts(AudioVisualItemType::all());
    $masterCounts = new TypeCounts(PreservationMasterType::all());
    $transferCounts = new TypeCounts(TransferType::all());

    // Recent activity
    $stream = new ActivityStream;
    $activities = $stream->activities();

    //dd($activities);

    return view('dashboard.index', compact('itemCounts', 'masterCounts', 
      'transferCounts', 'activities'));
  }

}
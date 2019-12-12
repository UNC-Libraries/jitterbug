<?php namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;

use Jitterbug\Http\Requests;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\PreservationMaster;

/**
 * Controller for operations related to call numbers.
 */
class CallNumbersController extends Controller {


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function generate(Request $request)
  {
    $formatId = $request->query('format');
    $collectionId = $request->query('collection');
    $sequence = CallNumberSequence::next($collectionId, $formatId);
    $callNumber = $sequence->callNumber();
    $response = array('callNumber' => $callNumber);
    return response()->json($response);
  }

  public function forPreservationMaster(Request $request)
  {
    $preservationMasterId = $request->query('preservation-master-id');
    $master = PreservationMaster::where('id', $preservationMasterId)->first();
    $response = array('callNumber' => $master === null ? '' : $master->call_number);
    return response()->json($response);
  }

}

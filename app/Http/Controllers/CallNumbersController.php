<?php namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;

use Jitterbug\Http\Requests;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\PreservationInstance;

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

  public function forPreservationInstance(Request $request)
  {
    $preservationInstanceId = $request->query('preservation-instance-id');
    $instance = PreservationInstance::where('id', $preservationInstanceId)->first();
    $response = array('callNumber' => $instance === null ? '' : $instance->call_number);
    return response()->json($response);
  }

}

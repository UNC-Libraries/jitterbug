<?php namespace Junebug\Http\Controllers;

use Illuminate\Http\Request;

use Junebug\Http\Requests;
use Junebug\Http\Controllers\Controller;
use Junebug\Models\CallNumberSequence;

/**
 * Controller for generating call numbers via ajax.
 */
class CallNumbersController extends Controller {

  public function generate(Request $request)
  {
    $formatId = $request->query('format');
    $collectionId = $request->query('collection');
    $sequence = CallNumberSequence::next($collectionId,$formatId);
    $callNumber = $sequence->callNumber();
    $response = array('callNumber' => $callNumber);
    return response()->json($response);
  }

}

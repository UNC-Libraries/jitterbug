<?php namespace Junebug\Http\Controllers;

use Log;
use Illuminate\Http\Request;

use Junebug\Http\Requests;
use Junebug\Http\Controllers\Controller;

class AlertsController extends Controller {

  /**
   * Get all alerts.
   *
   * @return Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      return response()->json($request->session()->get('alert'));
    }
  }

  /**
   * Clear the alert from the session.
   */
  public function destroy(Request $request)
  {
    $request->session()->forget('alert');
  }


}
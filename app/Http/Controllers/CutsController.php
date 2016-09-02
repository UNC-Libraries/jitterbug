<?php

namespace Junebug\Http\Controllers;

use Illuminate\Http\Request;

use Junebug\Http\Requests;
use Junebug\Models\Cut;
use Junebug\Models\PreservationMaster;

class CutsController extends Controller
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

  /**
   * Display the details of a cut.
   */
  public function show(Request $request, $masterId, $cutId)
  {
    $master = PreservationMaster::findOrFail($masterId);
    $cut = Cut::findOrFail($cutId);
    $transfer = $cut->transfer;
    return view('masters.cuts.show', compact('master', 'cut', 'transfer'));
  }
}

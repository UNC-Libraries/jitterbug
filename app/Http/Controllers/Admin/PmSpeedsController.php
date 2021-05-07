<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\PmSpeedRequest;
use Jitterbug\Models\PmSpeed;
use Jitterbug\Models\AudioInstance;

/**
 * Controller for the management of PM speeds in the Admin area.
 */
class PmSpeedsController extends Controller
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
      $records = PmSpeed::orderBy('name')->get();
      return view('admin._names', compact('records'));
    }
  }

  public function store(PmSpeedRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $pmSpeed = new PmSpeed;
      $pmSpeed->fill($input);
      $pmSpeed->save();
      return response()->json($pmSpeed);
    }
  }

  public function update($id, PmSpeedRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $pmSpeed = PmSpeed::findOrFail($id);
      $pmSpeed->fill($input);

      if ($pmSpeed->isDirty()) {

        // Update MySQL
        DB::transaction(function () use ($pmSpeed) {
          $pmSpeed->save();
        });
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = AudioInstance::where('sampling_rate_id', $id)->count();
      if ($count === 0) {
        $pmSpeed = PmSpeed::findOrFail($id);
        $pmSpeed->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that PM speed is currently ' .
          'in use. Change the PM speed of the related preservation ' .
          'masters before deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

}


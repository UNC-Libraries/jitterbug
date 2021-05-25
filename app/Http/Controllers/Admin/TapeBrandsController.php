<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\TapeBrandRequest;
use Jitterbug\Models\TapeBrand;
use Jitterbug\Models\AudioInstance;

/**
 * Controller for the management of tape brands in the Admin area.
 */
class TapeBrandsController extends Controller
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
      $records = TapeBrand::orderBy('name')->get();
      return view('admin._names', compact('records'));
    }
  }

  public function store(TapeBrandRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $tapeBrand = new TapeBrand;
      $tapeBrand->fill($input);
      $tapeBrand->save();
      return response()->json($tapeBrand);
    }
  }

  public function update($id, TapeBrandRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $tapeBrand = TapeBrand::findOrFail($id);
      $tapeBrand->fill($input);

      if ($tapeBrand->isDirty()) {

        // Update MySQL
        DB::transaction(function () use ($tapeBrand) {
          $tapeBrand->save();
        });
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = AudioInstance::where('sampling_rate_id', $id)->count();
      if ($count === 0) {
        $tapeBrand = TapeBrand::findOrFail($id);
        $tapeBrand->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that tape brand is currently ' .
          'in use. Change the tape brand of the related preservation ' .
          'instances before deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

}


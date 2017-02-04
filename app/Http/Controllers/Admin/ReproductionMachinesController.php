<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\ReproductionMachineRequest;
use Jitterbug\Models\ReproductionMachine;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of reproduction machines in the Admin area.
 */
class ReproductionMachinesController extends Controller
{

  protected $solrMasters;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
    $this->solrMasters = new SolariumProxy('jitterbug-masters');
  }

  public function index(Request $request) {
    if ($request->ajax()) {
      $records = ReproductionMachine::orderBy('name')->get();
      return view('admin._names', compact('records'));
    }
  }

  public function store(ReproductionMachineRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $reproductionMachine = new ReproductionMachine;
      $reproductionMachine->fill($input);
      $reproductionMachine->save();
      return response()->json($reproductionMachine);
    }
  }

  public function update($id, ReproductionMachineRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $reproductionMachine = ReproductionMachine::findOrFail($id);
      $reproductionMachine->fill($input);

      if ($reproductionMachine->isDirty()) {

        // Update MySQL
        DB::transaction(function () use ($reproductionMachine) {
          $reproductionMachine->save();
        });

        // Update Solr
        $affectedMasters = 
          PreservationMaster::where('reproduction_machine_id', $id)->get();
        $this->solrMasters->update($affectedMasters);
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = 
        PreservationMaster::where('reproduction_machine_id', $id)->count();
      if ($count === 0) {
        $reproductionMachine = ReproductionMachine::findOrFail($id);
        $reproductionMachine->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that reproduction machine is ' .
          'currently in use. Change the reproduction machine of the ' .
          'related preservation masters before deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

}


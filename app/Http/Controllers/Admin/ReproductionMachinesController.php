<?php

namespace Jitterbug\Http\Controllers\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\ReproductionMachineRequest;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\ReproductionMachine;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of reproduction machines in the Admin area.
 */
class ReproductionMachinesController extends Controller implements HasMiddleware
{
    protected $solrInstances;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->solrInstances = new SolariumProxy('jitterbug-instances');
    }

    public static function middleware(): array
    {
        return [
            ['auth', 'admin'],
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = ReproductionMachine::orderBy('name')->get();

            return view('admin._names', compact('records'));
        }
    }

    public function store(ReproductionMachineRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $reproductionMachine = new ReproductionMachine;
            $reproductionMachine->fill($input);
            $reproductionMachine->save();

            return response()->json($reproductionMachine);
        }
    }

    public function update($id, ReproductionMachineRequest $request)
    {
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
                $affectedInstances =
          PreservationInstance::where('reproduction_machine_id', $id)->get();
                $this->solrInstances->update($affectedInstances);
            }
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $count =
        PreservationInstance::where('reproduction_machine_id', $id)->count();
            if ($count === 0) {
                $reproductionMachine = ReproductionMachine::findOrFail($id);
                $reproductionMachine->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag;
                $bag->add('status', 'Looks like that reproduction machine is '.
          'currently in use. Change the reproduction machine of the '.
          'related preservation instances before deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }
}

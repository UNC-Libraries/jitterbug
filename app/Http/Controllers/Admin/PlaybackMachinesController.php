<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\PlaybackMachineRequest;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of playback machines in the Admin area.
 */
class PlaybackMachinesController extends Controller
{
    protected $solrTransfers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
        $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = PlaybackMachine::orderBy('name')->get();

            return view('admin._names', compact('records'));
        }
    }

    public function store(PlaybackMachineRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $playbackMachine = new PlaybackMachine;
            $playbackMachine->fill($input);
            $playbackMachine->save();

            return response()->json($playbackMachine);
        }
    }

    public function update($id, PlaybackMachineRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $playbackMachine = PlaybackMachine::findOrFail($id);
            $playbackMachine->fill($input);

            if ($playbackMachine->isDirty()) {

                // Update MySQL
                DB::transaction(function () use ($playbackMachine) {
                    $playbackMachine->save();
                });

                // Update Solr
                $affectedTransfers =
          Transfer::where('playback_machine_id', $id)->get();
                $this->solrTransfers->update($affectedTransfers);
            }
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $count = Transfer::where('playback_machine_id', $id)->count();
            if ($count === 0) {
                $playbackMachine = PlaybackMachine::findOrFail($id);
                $playbackMachine->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag;
                $bag->add('status', 'Looks like that playback machine is '.
          'currently in use. Change the playback machine of the '.
          'related transfers before deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }
}

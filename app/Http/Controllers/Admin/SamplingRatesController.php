<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\SamplingRateRequest;
use Jitterbug\Models\AudioInstance;
use Jitterbug\Models\SamplingRate;

/**
 * Controller for the management of sampling rates in the Admin area.
 */
class SamplingRatesController extends Controller
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

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = SamplingRate::orderBy('name')->get();

            return view('admin._names', compact('records'));
        }
    }

    public function store(SamplingRateRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $samplingRate = new SamplingRate;
            $samplingRate->fill($input);
            $samplingRate->save();

            return response()->json($samplingRate);
        }
    }

    public function update($id, SamplingRateRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $samplingRate = SamplingRate::findOrFail($id);
            $samplingRate->fill($input);

            if ($samplingRate->isDirty()) {

                // Update MySQL
                DB::transaction(function () use ($samplingRate) {
                    $samplingRate->save();
                });
            }
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $count = AudioInstance::where('sampling_rate_id', $id)->count();
            if ($count === 0) {
                $samplingRate = SamplingRate::findOrFail($id);
                $samplingRate->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag();
                $bag->add('status', 'Looks like that sampling rate is currently '.
          'in use. Change the sampling rate of the related preservation '.
          'instances before deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }
}

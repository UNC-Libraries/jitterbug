<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\PmSpeedRequest;
use Jitterbug\Models\AudioInstance;
use Jitterbug\Models\PmSpeed;

/**
 * Controller for the management of PM speeds in the Admin area.
 */
class PmSpeedsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            ['auth', 'admin'],
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = PmSpeed::orderBy('name')->get();

            return view('admin._names', compact('records'));
        }
    }

    public function store(PmSpeedRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $pmSpeed = new PmSpeed;
            $pmSpeed->fill($input);
            $pmSpeed->save();

            return response()->json($pmSpeed);
        }
    }

    public function update($id, PmSpeedRequest $request)
    {
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

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $count = AudioInstance::where('sampling_rate_id', $id)->count();
            if ($count === 0) {
                $pmSpeed = PmSpeed::findOrFail($id);
                $pmSpeed->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag;
                $bag->add('status', 'Looks like that PM speed is currently '.
          'in use. Change the PM speed of the related preservation '.
          'instances before deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }
}

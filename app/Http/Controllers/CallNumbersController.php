<?php

namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\PreservationInstance;

/**
 * Controller for operations related to call numbers.
 */
class CallNumbersController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function generate(Request $request)
    {
        $formatId = $request->query('format');
        $collectionId = $request->query('collection');
        $sequence = CallNumberSequence::next($collectionId, $formatId);
        $callNumber = $sequence->callNumber();
        $response = ['callNumber' => $callNumber];

        return response()->json($response);
    }

    public function forPreservationInstance(Request $request)
    {
        $preservationInstanceId = $request->query('preservation-instance-id');
        $instance = PreservationInstance::where('id', $preservationInstanceId)->first();
        $response = ['callNumber' => $instance === null ? '' : $instance->call_number];

        return response()->json($response);
    }
}

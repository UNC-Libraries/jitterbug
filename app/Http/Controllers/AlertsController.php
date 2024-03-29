<?php

namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;

class AlertsController extends Controller
{
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

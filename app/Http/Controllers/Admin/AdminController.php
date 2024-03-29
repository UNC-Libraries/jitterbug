<?php

namespace Jitterbug\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\User;

class AdminController extends Controller
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

    public function index()
    {
        return view('admin.index');
    }

    public function makeAdmin(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $username = $input['username'];
            $user = User::where('username', $username)->first();
            if ($user->inactive === 0) {
                $user->admin = 1;
                $user->save();

                return response()->json(['status' => 'success'], 200);
            }
            $bag = new MessageBag();
            $bag->add('status', 'That user is inactive, so they cannot be made admin.');

            return response()->json($bag, 422);
        }
    }

    public function removeAdmin(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $username = $input['username'];
            $user = User::where('username', $username)->first();
            $user->admin = 0;
            $user->save();

            return response()->json(['status' => 'success'], 200);
        }
    }
}

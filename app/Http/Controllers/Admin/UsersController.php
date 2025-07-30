<?php

namespace Jitterbug\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\Mark;
use Jitterbug\Models\User;

class UsersController extends Controller
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
            $records = User::hasLoggedIn()
                ->orderBy('inactive', 'ASC')
                ->get();

            return view('admin._users', compact('records'));
        }
    }

    public function inactivate(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $id = $input['id'];
            $user = User::findOrFail($id);
            $user->inactive = 1;
            $user->admin = 0;
            $user->save();

            // delete any existing marks made by the inactive user
            $numberOfDeletedMarks = Mark::where('user_id', $user->id)->delete();

            return response()->json(['marksDeleted' => $numberOfDeletedMarks]);
        }
    }

    public function reactivate(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $id = $input['id'];
            $user = User::findOrFail($id);
            $user->inactive = 0;
            $user->save();
        }
    }
}

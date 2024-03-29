<?php

namespace Jitterbug\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Jitterbug\Models\AudioVisualItemType;
use Jitterbug\Models\Mark;
use Jitterbug\Models\PreservationInstanceType;
use Jitterbug\Models\TransferType;
use Jitterbug\Models\User;
use Jitterbug\Presenters\ActivityStream;
use Jitterbug\Presenters\DashboardMark;
use Jitterbug\Presenters\TypeCounts;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Overview counts
        $itemCounts = new TypeCounts(AudioVisualItemType::all());
        $instanceCounts = new TypeCounts(PreservationInstanceType::all());
        $transferCounts = new TypeCounts(TransferType::all());

        // Recent activity module
        $stream = new ActivityStream;
        $activities = $stream->activities();

        // Marks module
        $marksUsers = User::has('marks')->get();
        $currentUser = Auth::user();
        $hasCurrentUser =
      $marksUsers->contains(function ($user, $key) use ($currentUser) {
          return $user->id === $currentUser->id;
      });
        if (! $hasCurrentUser) {
            $marksUsers->prepend($currentUser);
        }

        $marks = DashboardMark::fromMarks(
            $currentUser->marks()->orderBy('updated_at', 'desc')->get());

        return view('dashboard.index', compact('itemCounts', 'instanceCounts',
            'transferCounts', 'activities', 'marksUsers', 'currentUser', 'marks'));
    }

    /**
     * Return the marks for a given user.
     */
    public function marksForUser(Request $request)
    {
        if ($request->ajax()) {
            $selectedMarksUserId = (int) $request->query('id');
            $currentUser = Auth::user();
            $marks = DashboardMark::fromMarks(
                Mark::where('user_id', $selectedMarksUserId)
                ->orderBy('updated_at', 'desc')->get());

            return view('dashboard._marks',
                compact('selectedMarksUserId', 'currentUser', 'marks'));
        }
    }
}

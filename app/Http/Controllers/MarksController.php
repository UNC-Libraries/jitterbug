<?php namespace Jitterbug\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use Jitterbug\Http\Requests;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\Mark;

class MarksController extends Controller {

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Create a new mark if it doesn't exist, or
   * touch it if it already exists.
   */
  public function store(Request $request)
  {
    if ($request->ajax()) {
      $input = $request->all();
      $markableType = $input['markableType'];
      $markableId = $input['markableId'];
      $userId = Auth::user()->id;
      $mark = Mark::where('markable_type', $markableType)
                  ->where('markable_id', $markableId)
                  ->where('user_id', $userId)->first();
      if ($mark === null) {
        $mark = new Mark;
        $mark->markableType = $markableType;
        $mark->markableId = $markableId;
        $mark->userId = $userId;
      } else {
        $mark->touch();
      }

      $mark->save();

      $response = array('status'=>'success', 'id'=>$mark->id);
      return response()->json($response);
    }
  }

  public function batchStore(Request $request)
  {
    $markableType = $request->query('markableType');
    $markableIds = $request->query('markableIds');
    Auth::user()->id;
  }

  public function destroy(Request $request)
  {
    if ($request->ajax()) {
      $input = $request->all();
      $markableType = $input['markableType'];
      $markableId = $input['markableId'];
      $userId = Auth::user()->id;
      $mark = Mark::where('markable_type', $markableType)
                  ->where('markable_id', $markableId)
                  ->where('user_id', $userId)->first();
      if ($mark !== null) {
        $mark->delete();
      }

      $response = array('status'=>'success');
      return response()->json($response);
    }
  }

  public function batchDestroy(Request $request)
  {
    $markableType = $request->query('markableType');
    $markableIds = $request->query('markableIds');
    Auth::user()->id;
  }

}
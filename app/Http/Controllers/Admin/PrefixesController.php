<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\Prefix;
use Jitterbug\Http\Requests\PrefixRequest;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

/**
 * Controller for the management of Prefixes in the Admin area.
 */
class PrefixesController extends Controller
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

  public function index(Request $request) {
    if ($request->ajax()) {
      $records = Prefix::orderBy('label')->get();
      // TODO APPDEV-8639 need to write new view for this with different column
      return view('admin._names', compact('records'));
    }
  }

  public function store(PrefixRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $prefix = new Prefix;
      $prefix->fill($input);
      $prefix->save();
      return response()->json($prefix);
    }
  }

  public function update($id, PrefixRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $prefix = Prefix::findOrFail($id);
      $prefix->fill($input);

      if ($prefix->isDirty()) {

        // Update MySQL
        DB::transaction(function () use ($prefix) {
          $prefix->save();
        });
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $prefix = Prefix::findOrFail($id);
      $formatCount = $prefix->formats->count();
      if ($collectionCount === 0 && $prefixCount === 0) {
        $bag = new MessageBag();
        $prefix->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that collection type is currently ' .
          'in use. Change the collection type of the related collections ' .
          'and/or prefixes before deleting.');
        return response()->json($bag, 422);
      }
    }
  }
}
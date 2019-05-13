<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\CollectionType;
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
      $collectionTypes = CollectionType::orderBy('name')->get();
      return view('admin._prefixes', compact('records', 'collectionTypes'));
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
      //$formatCount = $prefix->formats->count();
      $prefix->detachAllFormats();
      $prefix->delete();
      $response = array('status'=>'success');
      //$bag = new MessageBag();
      //$bag->add('status', "Detaching the prefix from {$formatCount} formats.");
      return response()->json($response);
    }
  }
}
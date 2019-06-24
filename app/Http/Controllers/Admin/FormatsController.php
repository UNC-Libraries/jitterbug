<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\FormatRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Format;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of formats in the Admin area.
 */
class FormatsController extends Controller
{

  protected $solrItems;
  protected $solrMasters;
  protected $solrTransfers;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'admin']);
    $this->solrItems = new SolariumProxy('jitterbug-items');
    $this->solrMasters = new SolariumProxy('jitterbug-masters');
    $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
  }

  public function index(Request $request) {
    if ($request->ajax()) {
      $records = Format::orderBy('name')->get();
      return view('admin._formats', compact('records'));
    }
  }

  public function show($id) {
    $format = Format::findOrFail($id);
    $prefixes = $format->prefixes;
    return view('admin.formats.show', compact('format', 'prefixes'));
  }

  public function store(FormatRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $format = new Format;
      $format->fill($input);
      $format->save();
      return response()->json($format);
    }
  }

  public function update($id, FormatRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      $format = Format::findOrFail($id);
      $format->fill($input);

      if ($format->isDirty()) {
        $affectedItems;

        // Update MySQL
        DB::transaction(function () 
          use ($id, $format, &$affectedItems) {
          $format->save();

          $affectedItems = 
              AudioVisualItem::where('format_id', $format->id)->get();
        });

        // Update Solr
        $callNumbers = $affectedItems->pluck('call_number');
        $affectedMasters = 
          PreservationMaster::whereIn('call_number', $callNumbers)->get();
        $affectedTransfers =
          Transfer::whereIn('call_number', $callNumbers)->get();
        // We have to update all 3 cores because format information 
        // is stored in each core
        $this->solrItems->update($affectedItems);
        $this->solrMasters->update($affectedMasters);
        $this->solrTransfers->update($affectedTransfers);
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = AudioVisualItem::where('format_id', $id)->count();
      if ($count === 0) {
        $format = Format::findOrFail($id);
        $format->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that format is currently in use. ' . 
          'Change the format of the related audio visual items before ' .
          'deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

  public function detachPrefixes(Request $request) {
    if ($request->ajax()) {
      $format = Format::findOrFail($request->id);
      $format->detachPrefixes((integer) $request->prefixId);
      $response = array('status'=>'success');
      return response()->json($response);
    }
  }

}


<?php namespace Jitterbug\Http\Controllers\Admin;

use Auth;
use DB;
use Log;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\CollectionRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Collection;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of collections in the Admin area.
 */
class CollectionsController extends Controller
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
      $records = Collection::orderBy('name')->get();
      $collectionTypes = CollectionType::arrayForSelect();
      return view('admin._collections', compact('records', 'collectionTypes'));
    }
  }

  public function store(CollectionRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();
      $collection = new Collection;
      $collection->fill($input);

      // Update MySQL
      DB::transaction(function () use ($collection) {
        $collection->save();

        // Since this is a new collection, create new sequences 
        // for all format prefixes
        $results = DB::table('formats')->select('prefix')
                                       ->distinct()
                                       ->get();
        foreach ($results as $result) {
          $prefix = $result->prefix;
          $sequence = new NewCallNumberSequence;
          $sequence->prefix = $prefix;
          $sequence->collectionId = $collection->id;
          $sequence->next = 1;
          $sequence->save();
        }
      });

      return response()->json($collection);
    }
  }

  public function update($id, CollectionRequest $request) {
    if ($request->ajax()) {
      $input = $request->all();

      // If $input['id'] isn't set, the user is editing the name form
      if (!isset($input['id'])) {
        $input['id'] = $id;
      }

      $collection = Collection::findOrFail($id);
      $collection->fill($input);

      if ($collection->isDirty()) {
        $affectedItems;

        // Update MySQL
        DB::transaction(function () 
          use ($id, $collection, &$affectedItems) {
          if($collection->isDirty('id')) {
            // Mass update rather than item by item, otherwise
            // revision tracking will kick in.
            AudioVisualItem::where('collection_id', $id)
              ->update(['collection_id' => $collection->id]);
            NewCallNumberSequence::where('collection_id', $id)
              ->update(['collection_id' => $collection->id]);
          }
          $collection->save();

          $affectedItems = 
              AudioVisualItem::where('collection_id', $collection->id)->get();
        });

        // Update Solr
        $callNumbers = $affectedItems->pluck('call_number');
        $affectedMasters = 
          PreservationMaster::whereIn('call_number', $callNumbers)->get();
        $affectedTransfers =
          Transfer::whereIn('call_number', $callNumbers)->get();
        // We have to update all 3 cores because collection information 
        // is stored in each core
        $this->solrItems->update($affectedItems);
        $this->solrMasters->update($affectedMasters);
        $this->solrTransfers->update($affectedTransfers);
      }
    }
  }

  public function destroy($id, Request $request) {
    if ($request->ajax()) {
      $count = AudioVisualItem::where('collection_id', $id)->count();
      if ($count === 0) {
        $collection = Collection::findOrFail($id);
        $collection->delete();
        $response = array('status'=>'success');
        return response()->json($response);
      } else {
        $bag = new MessageBag();
        $bag->add('status', 'Looks like that collection is currently in use. ' . 
          'Remove audio visual items from the collection before deleting.');
        $response = $bag;
        return response()->json($bag, 422);
      }
    }
  }

}


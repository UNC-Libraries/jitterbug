<?php

namespace Jitterbug\Http\Controllers\Admin;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\CollectionRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Collection;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\NewCallNumberSequence;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of collections in the Admin area.
 */
class CollectionsController extends Controller implements HasMiddleware
{
    protected $solrItems;

    protected $solrInstances;

    protected $solrTransfers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->solrItems = new SolariumProxy('jitterbug-items');
        $this->solrInstances = new SolariumProxy('jitterbug-instances');
        $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
    }

    public static function middleware(): array
    {
        return [
            ['auth', 'admin'],
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = Collection::orderBy('name')->get();
            $collectionTypes = CollectionType::arrayForSelect();

            return view('admin._collections', compact('records', 'collectionTypes'));
        }
    }

    public function store(CollectionRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $collection = new Collection;
            $collection->fill($input);

            // Update MySQL
            DB::transaction(function () use ($collection) {
                $collection->save();

                // Since this is a new collection, create new sequences
                // for all prefixes with the same collection type ID
                $results = DB::table('prefixes')->select('label')
                    ->where('collection_type_id', '=', $collection->collection_type_id)
                    ->distinct()
                    ->get();
                foreach ($results as $result) {
                    $prefix = $result->label;
                    $sequence = new NewCallNumberSequence;
                    $sequence->prefix = $prefix;
                    $sequence->collection_id = $collection->id;
                    $sequence->archival_identifier = $collection->archival_identifier;
                    $sequence->next = 1;
                    $sequence->save();
                }
            });

            $collection['collectionTypeName'] = $collection->collectionType->name;

            return response()->json($collection);
        }
    }

    public function update($id, CollectionRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $collection = Collection::findOrFail($id);
            $collection->fill($input);

            if ($collection->isDirty()) {

                // Update MySQL
                DB::transaction(function () use ($id, $collection, &$affectedItems) {
                    if ($collection->isDirty('archival_identifier')) {
                        NewCallNumberSequence::where('collection_id', $id)
                            ->update(['archival_identifier' => $collection->archival_identifier]);
                    }

                    $collection->save();

                    $affectedItems =
              AudioVisualItem::where('collection_id', $collection->id)->get();
                });

                // Update Solr
                $callNumbers = $affectedItems->pluck('call_number');
                $affectedInstances =
          PreservationInstance::whereIn('call_number', $callNumbers)->get();
                $affectedTransfers =
          Transfer::whereIn('call_number', $callNumbers)->get();
                // We have to update all 3 cores because collection information
                // is stored in each core
                $this->solrItems->update($affectedItems);
                $this->solrInstances->update($affectedInstances);
                $this->solrTransfers->update($affectedTransfers);
            }
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $count = AudioVisualItem::where('collection_id', $id)->count();
            if ($count === 0) {
                $collection = Collection::findOrFail($id);
                $collection->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag;
                $bag->add('status', 'Looks like that collection is currently in use. '.
          'Remove audio visual items from the collection before deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }
}

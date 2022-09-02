<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\FormatRequest;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Format;
use Jitterbug\Models\Prefix;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of formats in the Admin area.
 */
class FormatsController extends Controller
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
        $this->middleware(['auth', 'admin']);
        $this->solrItems = new SolariumProxy('jitterbug-items');
        $this->solrInstances = new SolariumProxy('jitterbug-instances');
        $this->solrTransfers = new SolariumProxy('jitterbug-transfers');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = Format::orderBy('name')->get();

            return view('admin._formats', compact('records'));
        }
    }

    public function show($id)
    {
        $format = Format::findOrFail($id);
        $prefixes = $format->prefixes->sortBy('label');
        $possiblePrefixes = Prefix::possiblePrefixes($format->id);

        return view('admin.formats.show', compact('format', 'prefixes', 'possiblePrefixes'));
    }

    public function store(FormatRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $format = new Format;
            $format->fill($input);
            $format->save();

            return response()->json($format);
        }
    }

    public function update($id, FormatRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $format = Format::findOrFail($id);
            $format->fill($input);

            if ($format->isDirty()) {

                // Update MySQL
                DB::transaction(function () use ($format, &$affectedItems) {
                    $format->save();

                    $affectedItems =
              AudioVisualItem::where('format_id', $format->id)->get();
                });

                // Update Solr
                $callNumbers = $affectedItems->pluck('call_number');
                $affectedInstances =
          PreservationInstance::whereIn('call_number', $callNumbers)->get();
                $affectedTransfers =
          Transfer::whereIn('call_number', $callNumbers)->get();
                // We have to update all 3 cores because format information
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
            $count = AudioVisualItem::where('format_id', $id)->count();
            if ($count === 0) {
                $format = Format::findOrFail($id);
                $format->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag();
                $bag->add('status', 'Looks like that format is currently in use. '.
          'Change the format of the related audio visual items before '.
          'deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }

    public function detachPrefixes(Request $request)
    {
        if ($request->ajax()) {
            $format = Format::findOrFail($request->id);
            $format->detachPrefixes($request->prefixId);
            $response = ['status' => 'success'];

            return response()->json($response);
        }
    }

    public function attachPrefixes(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $format = Format::findOrFail($id);
            $format->attachPrefixes($request->prefixIds);
            $response = ['status' => 'success'];

            return response()->json($response);
        }
    }
}

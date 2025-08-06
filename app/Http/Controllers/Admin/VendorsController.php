<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\VendorRequest;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\Vendor;
use Jitterbug\Support\SolariumProxy;

/**
 * Controller for the management of vendors in the Admin area.
 */
class VendorsController extends Controller implements HasMiddleware
{
    protected $solrTransfers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

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
            $records = Vendor::orderBy('name')->get();

            return view('admin._names', compact('records'));
        }
    }

    public function store(VendorRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $vendor = new Vendor;
            $vendor->fill($input);
            $vendor->save();

            return response()->json($vendor);
        }
    }

    public function update($id, VendorRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $vendor = Vendor::findOrFail($id);
            $vendor->fill($input);

            if ($vendor->isDirty()) {

                // Update MySQL
                DB::transaction(function () use ($vendor) {
                    $vendor->save();
                });

                // Update Solr
                $affectedTransfers =
          Transfer::where('vendor_id', $id)->get();
                $this->solrTransfers->update($affectedTransfers);
            }
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $count = Transfer::where('vendor_id', $id)->count();
            if ($count === 0) {
                $vendor = Vendor::findOrFail($id);
                $vendor->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag;
                $bag->add('status', 'Looks like that vendor is currently in use. '.
          'Change the vendor of the related transfers before '.
          'deleting.');
                $response = $bag;

                return response()->json($bag, 422);
            }
        }
    }
}

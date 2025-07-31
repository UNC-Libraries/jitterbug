<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\PrefixRequest;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Prefix;

/**
 * Controller for the management of Prefixes in the Admin area.
 */
class PrefixesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            ['auth', 'admin'],
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $records = Prefix::orderBy('label')->get();
            $collectionTypes = CollectionType::arrayForSelect();

            return view('admin._prefixes', compact('records', 'collectionTypes'));
        }
    }

    public function store(PrefixRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $prefix = new Prefix;
            $prefix->fill($input);
            $prefix->save();
            $prefix['collectionTypeName'] = CollectionType::formattedName($prefix->collectionType);

            return response()->json($prefix);
        }
    }

    public function update($id, PrefixRequest $request)
    {
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

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $prefix = Prefix::findOrFail($id);
            $formatCount = $prefix->formats->count();
            $prefix->detachAllFormats();
            $prefix->delete();
            $message = ' '.$formatCount.' '.str_plural('format', $formatCount).
        ' detached from the deleted prefix.';
            $response = ['status' => 'success', 'message' => $message];

            return response()->json($response);
        }
    }

    public function setLegacyStatus(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $id = $input['id'];
            $prefix = Prefix::find($id);
            $prefix->legacy = 1;
            $prefix->save();
        }
    }

    public function removeLegacyStatus(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $id = $input['id'];
            $prefix = Prefix::find($id);
            $prefix->legacy = 0;
            $prefix->save();
        }
    }
}

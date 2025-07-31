<?php

namespace Jitterbug\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\MessageBag;
use Jitterbug\Http\Controllers\Controller;
use Jitterbug\Http\Requests\CollectionTypeRequest;
use Jitterbug\Models\Collection;
use Jitterbug\Models\CollectionType;
use Jitterbug\Models\Prefix;

/**
 * Controller for the management of collection types in the Admin area.
 */
class CollectionTypesController extends Controller implements HasMiddleware
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
            $records = CollectionType::orderBy('name')->get();

            return view('admin._names', compact('records'));
        }
    }

    public function store(CollectionTypeRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $collectionType = new CollectionType;
            $collectionType->fill($input);
            $collectionType->save();

            return response()->json($collectionType);
        }
    }

    public function update($id, CollectionTypeRequest $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $collectionType = CollectionType::findOrFail($id);
            $collectionType->fill($input);

            if ($collectionType->isDirty()) {

                // Update MySQL
                DB::transaction(function () use ($collectionType) {
                    $collectionType->save();
                });
            }
        }
    }

    public function destroy($id, Request $request)
    {
        if ($request->ajax()) {
            $collectionCount = Collection::where('collection_type_id', $id)->count();
            $prefixCount = Prefix::where('collection_type_id', $id)->count();
            if ($collectionCount === 0 && $prefixCount === 0) {
                $collectionType = CollectionType::findOrFail($id);
                $collectionType->delete();
                $response = ['status' => 'success'];

                return response()->json($response);
            } else {
                $bag = new MessageBag;
                $bag->add('status', 'Looks like that collection type is currently '.
          'in use. Change the collection type of the related collections '.
          'and/or prefixes before deleting.');

                return response()->json($bag, 422);
            }
        }
    }
}

<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Prefix extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['label', 'legacy', 'collection_type_id'];

    public function collectionType()
    {
        return $this->belongsTo(CollectionType::class);
    }

    public function formats()
    {
        return $this->belongsToMany(Format::class)->withTimestamps();
    }

    public function detachAllFormats()
    {
        $this->formats()->detach();
    }

    public static function findPrefixLabel($formatId, $collectionId)
    {
        $collectionTypeIdQuery = DB::table('collections')->select('collection_type_id')
                                                     ->where('id', '=', $collectionId)
                                                     ->get()
                                                     ->first();

        if ($collectionTypeIdQuery === null) {
            $message = 'Collection does not have a collection type ID.';
            abort(404, $message);
        }

        $collectionTypeId = $collectionTypeIdQuery->collection_type_id;

        // find the prefix attached to the specified format
        // that has the same collection type ID as the specified collection
        $labelQuery = DB::table('prefixes')->select('label')
                                       ->join('format_prefix', 'prefixes.id', '=', 'format_prefix.prefix_id')
                                       ->where([
                                           ['format_prefix.format_id', '=', $formatId],
                                           ['prefixes.collection_type_id', '=', $collectionTypeId],
                                       ])
                                       ->get()
                                       ->first();

        if ($labelQuery === null) {
            abort(404, 'Unable to find prefix for this format ID and collection ID.');
        }

        return $labelQuery->label;
    }

    public static function possiblePrefixes($formatId)
    {
        $arrayForSelect = [];
        $prefixObjects = self::whereDoesntHave('formats', function ($q) use ($formatId) {
            $q->where('id', $formatId);
        })->orderBy('label')->get()->all();

        foreach ($prefixObjects as $prefix) {
            $label = $prefix->label;
            $collectionTypeName = CollectionType::formattedName($prefix->collectionType);
            $dropdownName = $label.' -- '.$collectionTypeName.' Collection';
            $arrayForSelect[$prefix->id] = $dropdownName;
        }

        return $arrayForSelect;
    }

    private static function useLegacyPrefix($collectionId, $collectionTypeId)
    {
        // if it's an SHC collection, see if there are any items in this collection
        // that already start with the FD prefix
        if ($collectionTypeId == 4) {
            $query = DB::table('audio_visual_items')->select('id')
            ->where([
                ['collection_id', '=', $collectionId],
                ['call_number', 'LIKE', 'FD-%']
            ])
            ->limit(1);
            // if there are no FD prefixes already in use then use legacy
            return $query.length == 0;
        }
        return false;
    }
}

<?php


namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Log;

class Prefix extends Model
{
  use SoftDeletes;

  protected $fillable = array('label', 'legacy', 'collection_type_id');

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
      Log::error($message);
      abort(404, $message);
    }

    $collectionTypeId = $collectionTypeIdQuery->collection_type_id;

    # find the prefix attached to the specified format
    # that has the same collection type ID as the specified collection
    $labelQuery = DB::table('prefixes')->select('label')
                                       ->join('format_prefix', 'prefixes.id', '=', 'format_prefix.prefix_id')
                                       ->where([
                                         ['format_prefix.format_id', '=', $formatId],
                                         ['prefixes.collection_type_id', '=', $collectionTypeId]
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
      $dropdownName = $label . ' -- ' . $collectionTypeName . ' Collection';
      $arrayForSelect[$prefix->id] = $dropdownName;
    }

    return $arrayForSelect;
  }
}

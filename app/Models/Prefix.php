<?php


namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Prefix extends Model
{
  use SoftDeletes;
  use CamelCasing;

  protected $fillable = array('label', 'legacy', 'collectionTypeId');

  public function collectionType()
  {
    return $this->belongsTo(CollectionType::class);
  }

  public function formats()
  {
    return $this->belongsToMany(Format::class);
  }

  public function detachAllFormats()
  {
    $this->formats()->detach();
  }

  public static function findPrefixLabel($formatId, $collectionId)
  {
    $collectionTypeId = DB::table('collections')->select('collection_type_id')
                                                ->where('id', '=', $collectionId)
                                                ->get()
                                                ->first()->collection_type_id;

    # find the prefix attached to the specified format
    # that has the same collection type ID as the specified collection
    $label = DB::table('prefixes')->select('label')
                                  ->join('format_prefix', 'prefixes.id', '=', 'format_prefix.prefix_id')
                                  ->where([
                                    ['format_prefix.format_id', '=', $formatId],
                                    ['prefixes.collection_type_id', '=', $collectionTypeId]
                                  ])
                                  ->get()
                                  ->first()->label;

    if ($label === null) {
      $label = Format::findOrFail($formatId)->prefix;
    }

    return $label;
  }
}

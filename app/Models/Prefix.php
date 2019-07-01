<?php


namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    return $this->belongsToMany(Format::class)->withTimestamps();;
  }

  public function detachAllFormats()
  {
    $this->formats()->detach();
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

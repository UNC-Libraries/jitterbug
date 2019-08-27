<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Collection extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $fillable = array('id', 'name', 'collectionTypeId', 'archivalIdentifier');

  public $incrementing = false;

  public function audioVisualItems()
  {
    return $this->hasMany('Jitterbug\Models\AudioVisualItem');
  }

  public function collectionType()
  {
    return $this->belongsTo(CollectionType::class);
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }

  public static function autoIncrementIdsScript()
  {
    $collections = self::withTrashed()->get();
    $idTracker = 1;
    $collectionIdMapping = [];

    foreach ($collections as $collection) {
      $oldId = $collection->id;
      $collection->id = $idTracker;
      $collection->save();

      $collectionIdMapping[$oldId] = $idTracker;

      $idTracker++;
    }
    return $collectionIdMapping;
  }

  // $tableName should be snake case, plural string
  public static function updateCollectionIdInTable($tableName, $collectionIdMapping)
  {
    $brokenIds = array();
    DB::table($tableName)
      ->whereNotNull('collection_id')
      ->chunkById(1000, function ($results) use (&$brokenIds, &$collectionIdMapping, $tableName) {
       foreach ($results as $result) {
         if (isset($collectionIdMapping[$result->collection_id])) {
           $newCollectionId = $collectionIdMapping[$result->collection_id];
         } else {
           $brokenIds[] = $result->id;
           continue;
         }

         DB::table($tableName)
           ->where('id', $result->id)
           ->update(['collection_id' => $newCollectionId]);
       }
    });

    return $brokenIds;
  }
}
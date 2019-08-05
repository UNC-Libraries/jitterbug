<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    //$collections = self::all();
    $collections = Collection::whereIn('id', [100, 200])->get();
    $idTrack = 1;
    $collectionIdMapping = [];

    foreach ($collections as $collection) {
      $oldId = $collection->id;
      $collection->id = $idTrack;
      $collection->save();

      $collectionIdMapping[$oldId] = $idTrack;

      $idTrack++;
    }
    return $collectionIdMapping;
  }

  public static function updateCollectionIdInAudioVisualItems($collectionIdMapping)
  {
    //$avItems = AudioVisualItem::all();
    $avItems = AudioVisualItem::whereIn('id', [1,2,3]);
    $brokenAvItemIds = [];

    foreach ($avItems as $avItem) {
      $oldCollectionId = $avItem->collection_id;
      if ($oldCollectionId === null) {
        $brokenAvItemIds[] = $avItem->id;
        continue;
      }

      $avItem->collection_id = $collectionIdMapping[$oldCollectionId];
      if ($avItem->collection_id === null) {
        $brokenAvItemIds[] = $avItem->id;
        continue;
      }

      $avItem->save();
    }
    return $brokenAvItemIds;
  }

  public static function updateCollectionIdInNewCallNumberSequences($collectionIdMapping)
  {
    $sequences = NewCallNumberSequence::all();
    $brokenSequenceIds = [];

    foreach($sequences as $sequence) {
      $oldCollectionId = $sequence->collection_id;

      $sequence->collection_id = $collectionIdMapping[$oldCollectionId];
      if ($sequence->collection_id === null) {
        $brokenSequenceIds[] = $sequence->id;
        continue;
      }

      $sequence->save();
    }
    return $brokenSequenceIds;
  }
}
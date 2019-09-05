<?php namespace Jitterbug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CallNumberSequence extends Model {
  use CamelCasing;

  const ALWAYS_USE_NEW_STYLE = array('F', 'VM', 'VT');

  public static function next($collectionId, $formatId)
  {
    $prefix = Prefix::findPrefixLabel($formatId, $collectionId);
    $archivalIdentifier = Collection::find($collectionId)->archivalIdentifier;

    $sequence = NewCallNumberSequence::where('prefix', '=', $prefix)->
                  where('collection_id', '=', $collectionId)->first();
    if ($sequence === null) {
      if (in_array($prefix, self::ALWAYS_USE_NEW_STYLE)) {
        $sequence = new NewCallNumberSequence();
        $sequence->prefix = $prefix;
        $sequence->collectionId = $collectionId;
        $sequence->archivalIdentifier = $archivalIdentifier;
        $sequence->next = 1;
        $sequence->save();
      } else {
        $sequence = LegacyCallNumberSequence::
                    where('prefix', '=', $prefix)->first();
      }
    }

    if ($sequence === null) {
      Log::error('No new or legacy sequence found for prefix \'' . $prefix . 
        '\'' . ' with collection id ' . $collectionId);
    }

    // TODO Do a final check in audio visual items to make sure there
    // isn't already an item with this call number? And if so go to 
    // the next sequence?

    return $sequence;
  }
  
  /**
   * Increment the sequence id.
   */
  public function increase()
  {
    $reservedIds = array();
    if ($this->reserved !== null) {
      $reservedIds = explode(',', $this->reserved);
    }
    $this->next++;
    while (in_array($this->next , $reservedIds)) {
      $this->next++;
    }
    $this->save();
  }

  public static function backfillSequencesForNewCollectionTypes($collectionTypeId)
  {
    $prefixes = DB::table('prefixes')->select('label')
      ->where('collection_type_id', '=', $collectionTypeId)
      ->distinct()
      ->get();

    $collections = DB::table('collections')->where('collection_type_id', '=', $collectionTypeId)->get();

    foreach ($collections as $collection)  {
      echo $collection->id . ':';
      foreach ($prefixes as $prefix) {
        echo '&-';
        $sequenceExists = DB::table('new_call_number_sequences')
                          ->where('prefix', '=', $prefix->label)
                          ->where('collection_id', '=', $collection->id)
                          ->exists();

        if (!$sequenceExists) {
          $sequence = new NewCallNumberSequence();
          $sequence->prefix = $prefix->label;
          $sequence->collection_id = $collection->id;
          $sequence->archival_identifier = $collection->archival_identifier;
          $sequence->next = 1;
          $sequence->save();
        }
      }
    }
  }
}
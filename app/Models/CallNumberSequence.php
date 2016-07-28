<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;

use Eloquence\Database\Traits\CamelCaseModel;

class CallNumberSequence extends Model {
  use CamelCaseModel;

  const ALWAYS_USE_NEW_STYLE = array('F', 'VM', 'VT');

  public static function next($collectionId, $formatId)
  {
    $collection = Collection::findOrFail($collectionId);
    $prefix = Format::findOrFail($formatId)->prefix;

    $sequence = NewCallNumberSequence::where('prefix', '=', $prefix)->
                  where('collection_id', '=', $collectionId)->get()->first();
    if ($sequence === null) {
      if (in_array($prefix, self::ALWAYS_USE_NEW_STYLE)) {
        $sequence = new NewCallNumberSequence();
        $sequence->prefix = $prefix;
        $sequence->collectionId = $collectionId;
        $sequence->next = 1;
        $sequence->save();
      } else {
        $sequence = LegacyCallNumberSequence::
                    where('prefix', '=', $prefix)->get()->first();
      }
    }

    if ($sequence === null) {
      Log::error('No new or legacy sequence found for prefix \'' . $prefix . 
        '\'' . ' with collection id ' . $collectionId);
    }

    // Do a final check in items to make sure there isn't an item with this call number?

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
    while(in_array($this->next , $reservedIds)) {
      $this->next++;
    }
    $this->save();
  }

}
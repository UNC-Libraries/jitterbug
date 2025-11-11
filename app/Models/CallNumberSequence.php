<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class CallNumberSequence extends Model
{
    const ALWAYS_USE_NEW_STYLE = ['F', 'VM', 'VT'];

    public static function next($collectionId, $formatId)
    {
        $prefix = Prefix::findPrefixLabel($formatId, $collectionId);
        $archivalIdentifier = Collection::find($collectionId)->archival_identifier;

        $sequence = NewCallNumberSequence::where('prefix', '=', $prefix)->
                  where('collection_id', '=', $collectionId)->first();
        if ($sequence === null) {
            if (in_array($prefix, self::ALWAYS_USE_NEW_STYLE)) {
                $sequence = new NewCallNumberSequence;
                $sequence->prefix = $prefix;
                $sequence->collection_id = $collectionId;
                $sequence->archival_identifier = $archivalIdentifier;
                $sequence->next = 1;
                $sequence->save();
            } else {
                $sequence = LegacyCallNumberSequence::where('prefix', '=', $prefix)->first();
            }
        }

        if ($sequence === null) {
            Log::error('No new or legacy sequence found for prefix \''.$prefix.
        '\''.' with collection id '.$collectionId);
        }

    // if the call number is already in use, use the next one
    $avItem = AudioVisualItem::where('call_number', '=', $sequence->callNumber());
    if ($avItem != null) {
        $increasedSequence = $sequence->increase();
    }

        return $sequence;
    }

    /**
     * Increment the sequence id.
     */
    public function increase()
    {
        $reservedIds = [];
        if ($this->reserved !== null) {
            $reservedIds = explode(',', $this->reserved);
        }
        $this->next++;
        while (in_array($this->next, $reservedIds)) {
            $this->next++;
        }
        $this->save();
    }
}

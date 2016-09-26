<?php namespace Junebug\Models;

use Log;

trait CompositeHistory
{
  public function completeRevisionHistory()
  {
    $revisionHistory = $this->revisionHistory()->get();
    $childRevisionHistory = null;
    if (method_exists($this, 'itemable')) {
      $childRevisionHistory = $this->itemable->revisionHistory()->get();
    } else if (method_exists($this, 'masterable')) {
      $childRevisionHistory = $this->masterable->revisionHistory()->get();
    } else if (method_exists($this, 'transferable')) {
      $childRevisionHistory = $this->transferable->revisionHistory()->get();
    }

    $completeRevisionHistory = $revisionHistory->merge($childRevisionHistory);
    $completeRevisionHistory = $completeRevisionHistory->sortBy('created_at');

    // Revisions that appear to be duplicate to the user are possible 
    // in the case of a call number update, which updates the call 
    // numbers on both AudioVisualItem and AudioItem (or FilmItem,
    // VideoItem), and creation dates. So, we remove the 'duplicates' here.
    $historyKeys = array();
    foreach ($completeRevisionHistory as $arrayKey => $history) {
      $historyKey = $history->transaction_id.$history->field;
      if (in_array($historyKey,$historyKeys)) {
        $completeRevisionHistory->pull($arrayKey);
      } else {
        array_push($historyKeys,$historyKey);
      }
    }

    return $completeRevisionHistory;
  }
}



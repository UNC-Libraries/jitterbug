<?php namespace Jitterbug\Models;

use Log;

trait CompositeHistory
{

  public function completeRevisionHistory()
  {
    $revisionHistory = $this->revisionHistory;
    $childRevisionHistory = null;
    $childRevisionHistory = $this->subclass->revisionHistory;
    $completeRevisionHistory = $revisionHistory->merge($childRevisionHistory);
    $completeRevisionHistory = $completeRevisionHistory->sortBy('created_at');

    // Revisions that appear to be duplicate to the user are possible 
    // in the case of a call number update, which updates the call 
    // numbers on both AudioVisualItem and AudioItem (or FilmItem,
    // VideoItem), and creation dates. So, we remove the 'duplicates' here.
    $historyKeys = array();
    foreach ($completeRevisionHistory as $arrayKey => $history) {
      $historyKey = $history->transaction_id.$history->field;
      if (in_array($historyKey, $historyKeys)) {
        $completeRevisionHistory->pull($arrayKey);
      } else {
        $historyKeys[] =$historyKey;
      }
    }

    return $completeRevisionHistory;
  }

  public function getCreatedOnDisplayAttribute()
  {
    $revisionHistory = $this->completeRevisionHistory();
    return $this->formattedHistory($revisionHistory->first());
  }

  public function getUpdatedOnDisplayAttribute()
  {
    $revisionHistory = $this->completeRevisionHistory();
    $revisionHistory = $revisionHistory->sortByDesc('created_at');
    return $this->formattedHistory($revisionHistory->first());
  }

  public function formattedHistory($history)
  {
    $user = $history->userResponsible()->first_name
      . ' ' . $history->userResponsible()->last_name;
    $date =  date('n/j/Y', strtotime($history->created_at));
    return $date . ' by ' . $user;
  }
}



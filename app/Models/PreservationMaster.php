<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class PreservationMaster extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];
  
  protected $revisionCreationsEnabled = true;

  public function department()
  {
    return $this->belongsTo('Junebug\Models\Department');
  }

  public function cuts()
  {
    return $this->hasMany('Junebug\Models\Cut', 'call_number');
  }

  public function masterable()
  {
    return $this->morphTo();
  }

  public function getTypeAttribute()
  {
  	$fullType = $this->getAttribute("masterableType");
    $type = substr($fullType,0,strlen($fullType)
    	- strlen("Master"));
    return $type;
  }

  public function getDurationAttribute()
  {
    $durationInSeconds = $this->getAttribute("durationInSeconds");
    $duration = "";
    if($durationInSeconds) {
      $minutes = (int) ($durationInSeconds / 60);
      $seconds = $minutes == 0 ? $durationInSeconds : 
        $durationInSeconds % ($minutes * 60);

      if($minutes) {
        $duration = $minutes . "' ";
      }
      if($seconds) {
        $duration = $duration . $seconds . "\"";
      }
    }
    return $duration;
  }

  /**
   * Merges the revision histories of the preservation master and the
   * associated audio/film/video master since they should appear as one
   * to the end user.
   * 
   * @return Collection
   */
  public function completeRevisionHistory()
  {
    $masterRevisionHistory = $this->revisionHistory()->get();
    $masterableRevisionHistory = $this->masterable->revisionHistory()->get();
    $completeRevisionHistory = $masterRevisionHistory->
                               merge($masterableRevisionHistory);
    $completeRevisionHistory = $completeRevisionHistory->sortBy('created_at');

    $compositeKeys = array();
    foreach ($completeRevisionHistory as $key => $history) {
      $compositeKey = $history->transaction_id.$history->field.
                      $history->old_value.$history->new_value;
      if(in_array($compositeKey,$compositeKeys)) {
        $completeRevisionHistory->pull($key);
      } else {
        array_push($compositeKeys,$compositeKey);
      }
    }

    return $completeRevisionHistory;
  }
  
}
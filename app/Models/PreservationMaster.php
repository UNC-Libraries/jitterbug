<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class PreservationMaster extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use RevisionableTrait;

  protected $revisionCreationsEnabled = true;

  public function department()
  {
    return $this->belongsTo('Junebug\Models\Department');
  }

  public function getTypeAttribute()
  {
  	$fullType = $this->getAttribute("masterableType");
    $type = substr($fullType,0,strlen($fullType)
    	- strlen("PreservationMaster"));
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
  
}
<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class AudioItem extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use Auditable;

  protected $guarded = ['id'];

  public function getListeningCopyDisplayAttribute()
  {
  	$listeningCopy = $this->getAttribute("listeningCopy");

    if($listeningCopy=='N') {
      $listeningCopy = 'No';
    } else {
      $listeningCopy = 'Yes';
    }
    return $listeningCopy; 
  }

  public function getMonoStereoAttribute() {
    $monoStereo = $this->attributes['mono_stereo'];
    if($monoStereo==null) {
      $monoStereo = '';
    }
    return $monoStereo; 
  }

  public function getMonoStereoDisplayAttribute()
  {
  	$monoStereo = $this->getAttribute("monoStereo");

    if($monoStereo=='M') {
      $monoStereo = 'Mono';
    } else if($monoStereo=='S')  {
      $monoStereo = 'Stereo';
    } else {
      $monoStereo = null;
    }
    return $monoStereo; 
  }

}
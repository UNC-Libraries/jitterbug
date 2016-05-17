<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class AudioItem extends Model {
  use CamelCaseModel;

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
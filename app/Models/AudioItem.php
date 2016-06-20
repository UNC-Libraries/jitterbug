<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioItem extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'size' => 'isEmpty:nothing|%s',
    'track_configuration' => 'isEmpty:nothing|%s',
    'mono_stereo' => 'isEmpty:nothing|%s',
    'base' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'listening_copy' => 'listening copy',
    'track_configuration' => 'track configuration',
    'mono_stereo' => 'mono/stereo',
  );

  protected $fillable = ['callNumber','listeningCopy','audioMonoStereo',
                         'trackConfiguration','size','audioBase'];

  public function getListeningCopyDisplayAttribute($value)
  {
    $listeningCopy = ($value==null ? $this->listeningCopy : $value);
    if($listeningCopy) {
      return 'Yes';
    } else {
      return 'No';
    }
  }

  public function getMonoStereoDisplayAttribute($value)
  {
    $monoStereo = ($value==null ? $this->monoStereo : $value);
    if($monoStereo=='M') {
      $monoStereo = 'Mono';
    } else if($monoStereo=='S')  {
      $monoStereo = 'Stereo';
    } else {
      $monoStereo = '';
    }
    return $monoStereo; 
  }

  public function getMonoStereoAttribute($value)
  {
    if($value==null) {
      return '';
    }
    return $value;
  }

  public function getAudioMonoStereoAttribute($value) {
    return $value==null ? $this->monoStereo : $value;
  }

  public function setAudioMonoStereoAttribute($value) {
    $this->monoStereo = $value;
  }

  public function getAudioBaseAttribute($value) {
    return $value==null ? $this->base : $value;
  }

  public function setAudioBaseAttribute($value) {
    $this->base = $value;
  }

}
<?php namespace Jitterbug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class AudioItem extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'size' => 'isEmpty:nothing|%s',
    'track_configuration' => 'isEmpty:nothing|%s',
    'mono_stereo' => 'isEmpty:nothing|%s',
    'base' => 'isEmpty:nothing|%s',
    'content_description' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'listening_copy' => 'listening copy',
    'track_configuration' => 'track configuration',
    'mono_stereo' => 'mono/stereo',
    'content_description' => 'content description',
  );

  protected $fillable = array('callNumber','listeningCopy',
    'audioMonoStereo', 'trackConfiguration','size','audioBase',
    'audioContentDescription');

  public function getListeningCopyDisplayAttribute($value)
  {
    $listeningCopy = ($value===null ? $this->listeningCopy : $value);
    if($listeningCopy) {
      return 'Yes';
    } else {
      return 'No';
    }
  }

  public function getMonoStereoDisplayAttribute($value)
  {
    $monoStereo = ($value===null ? $this->monoStereo : $value);
    if($monoStereo==='M') {
      $monoStereo = 'Mono';
    } else if($monoStereo==='S')  {
      $monoStereo = 'Stereo';
    } else {
      $monoStereo = '';
    }
    return $monoStereo; 
  }

  public function getMonoStereoAttribute($value)
  {
    if($value===null) {
      return '';
    }
    return $value;
  }

  public function getAudioMonoStereoAttribute($value) {
    return $value===null ? $this->monoStereo : $value;
  }

  public function setAudioMonoStereoAttribute($value) {
    $this->monoStereo = $value;
  }

  public function getAudioBaseAttribute($value) {
    return $value===null ? $this->base : $value;
  }

  public function setAudioBaseAttribute($value) {
    $this->base = $value;
  }

  public function getAudioContentDescriptionAttribute($value)
  {
    return $value===null ? $this->contentDescription : $value;
  }

  public function setAudioContentDescriptionAttribute($value)
  {
    $this->contentDescription = $value;
  }

}
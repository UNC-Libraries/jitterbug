<?php namespace Jitterbug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class AudioItem extends Model {
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

  protected $fillable = array('call_number', 'listening_copy',
    'audio_mono_stereo', 'track_configuration', 'size', 'audio_base',
    'audio_content_description');

  public function superclass()
  {
    return $this->morphOne('AudioVisualItem', 'subclass')->withTrashed();
  }

  public function getListeningCopyDisplayAttribute($value)
  {
    $listeningCopy = ($value===null ? $this->listening_copy : $value);
    if($listeningCopy) {
      return 'Yes';
    } else {
      return 'No';
    }
  }

  public function getMonoStereoDisplayAttribute($value)
  {
    $monoStereo = ($value===null ? $this->mono_stereo : $value);
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

  public function getAudioMonoStereoAttribute($value)
  {
    return $value===null ? $this->mono_stereo : $value;
  }

  public function setAudioMonoStereoAttribute($value)
  {
    $this->mono_stereo = $value;
  }

  public function getAudioBaseAttribute($value)
  {
    return $value===null ? $this->base : $value;
  }

  public function setAudioBaseAttribute($value)
  {
    $this->base = $value;
  }

  public function getAudioContentDescriptionAttribute($value)
  {
    return $value===null ? $this->content_description : $value;
  }

  public function setAudioContentDescriptionAttribute($value)
  {
    $this->content_description = $value;
  }

}
<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class AudioItem extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;
  use HasFactory;

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
    $listeningCopy = $value ?? $this->listening_copy;
    if($listeningCopy) {
      return 'Yes';
    } else {
      return 'No';
    }
  }

  public function getMonoStereoDisplayAttribute($value)
  {
    $monoStereo = $value ?? $this->mono_stereo;
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
    return $value ?? $this->mono_stereo;
  }

  public function setAudioMonoStereoAttribute($value)
  {
    $this->mono_stereo = $value;
  }

  public function getAudioBaseAttribute($value)
  {
    return $value ?? $this->base;
  }

  public function setAudioBaseAttribute($value)
  {
    $this->base = $value;
  }

  public function getAudioContentDescriptionAttribute($value)
  {
    return $value ?? $this->content_description;
  }

  public function setAudioContentDescriptionAttribute($value)
  {
    $this->content_description = $value;
  }

}
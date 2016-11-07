<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class VideoItem extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'element' => 'isEmpty:nothing|%s',
    'color' => 'isEmpty:nothing|%s',
    'mono_stereo' => 'isEmpty:nothing|%s',
    'content_description' => 'isEmpty:nothing|%s',
    'recording_standard' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'element' => 'element',
    'color' => 'color',
    'mono_stereo' => 'mono/stereo',
    'content_description' => 'content description',
    'recording_standard' => 'recording standard',
  );

  protected $fillable = array('callNumber','videoElement', 
    'videoColor', 'videoMonoStereo', 
    'videoContentDescription', 'recordingStandard');

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

  public function getVideoColorAttribute($value)
  {
    return $value==null ? $this->color : $value;
  }

  public function setVideoColorAttribute($value)
  {
    $this->color = $value;
  }

  public function getVideoElementAttribute($value)
  {
    return $value==null ? $this->element : $value;
  }

  public function setVideoElementAttribute($value)
  {
    $this->element = $value;
  }

  public function getVideoMonoStereoAttribute($value)
  {
    return $value==null ? $this->monoStereo : $value;
  }

  public function setVideoMonoStereoAttribute($value)
  {
    $this->monoStereo = $value;
  }

  public function getVideoContentDescriptionAttribute($value)
  {
    return $value==null ? $this->contentDescription : $value;
  }

  public function setVideoContentDescriptionAttribute($value)
  {
    $this->contentDescription = $value;
  }
}

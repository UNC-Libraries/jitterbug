<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class VideoMaster extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'frame_size' => 'isEmpty:nothing|%s',
    'aspect_ratio' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'frame_size' => 'frame size',
    'aspect_ratio' => 'aspect ratio',
  );

  protected $fillable = array('video_frame_size', 'video_aspect_ratio');

  public function superclass()
  {
    return $this->morphOne('PreservationMaster', 'subclass')->withTrashed();
  }
  
  public function getVideoFrameSizeAttribute($value)
  {
    return $value===null ? $this->frameSize : $value;
  }

  public function setVideoFrameSizeAttribute($value)
  {
    $this->frameSize = $value;
  }

  public function getVideoAspectRatioAttribute($value)
  {
    return $value===null ? $this->aspect_ratio : $value;
  }

  public function setVideoAspectRatioAttribute($value)
  {
    $this->aspect_ratio = $value;
  }
}
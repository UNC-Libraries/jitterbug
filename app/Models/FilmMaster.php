<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class FilmMaster extends Model {
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

  protected $fillable = array('film_frame_size', 'film_aspect_ratio');

  public function superclass()
  {
    return $this->morphOne('PreservationMaster', 'subclass')->withTrashed();
  }
  
  public function getFilmFrameSizeAttribute($value)
  {
    return $value===null ? $this->frame_size : $value;
  }

  public function setFilmFrameSizeAttribute($value)
  {
    $this->frame_size = $value;
  }

  public function getFilmAspectRatioAttribute($value)
  {
    return $value===null ? $this->aspect_ratio : $value;
  }

  public function setFilmAspectRatioAttribute($value)
  {
    $this->aspect_ratio = $value;
  }

}
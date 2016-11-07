<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class FilmMaster extends Model {
  use CamelCasing;
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

  protected $fillable = array('filmFrameSize', 'filmAspectRatio');

  public function getFilmFrameSizeAttribute($value) {
    return $value===null ? $this->frameSize : $value;
  }

  public function setFilmFrameSizeAttribute($value) {
    $this->frameSize = $value;
  }

  public function getFilmAspectRatioAttribute($value) {
    return $value===null ? $this->aspectRatio : $value;
  }

  public function setFilmAspectRatioAttribute($value) {
    $this->aspectRatio = $value;
  }

}
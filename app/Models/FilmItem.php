<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class FilmItem extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'element' => 'isEmpty:nothing|%s',
    'base' => 'isEmpty:nothing|%s',
    'color' => 'isEmpty:nothing|%s',
    'sound_type' => 'isEmpty:nothing|%s',
    'length_in_feet' => 'isEmpty:nothing|%s',
    'film_stock' => 'isEmpty:nothing|%s',
    'edge_code' => 'isEmpty:nothing|%s',
    'shrinkage_percent' => 'isEmpty:nothing|%s',
    'can_number' => 'isEmpty:nothing|%s',
    'content_description' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'sound_type' => 'sound type',
    'length_in_feet' => 'length in feet',
    'film_stock' => 'film stock',
    'edge_code' => 'edge code',
    'shrinkage_percent' => 'shrinkage percent',
    'can_number' => 'can number',
    'content_description' => 'content description',
  );

  protected $fillable = ['callNumber','filmElement','filmBase', 'filmColor',
        'soundType','lengthInFeet','filmStock','edgeCode',
        'shrinkagePercent','canNumber','filmContentDescription'];

  public function getFilmColorAttribute($value)
  {
    return $value===null ? $this->color : $value;
  }

  public function setFilmColorAttribute($value)
  {
    $this->color = $value;
  }

  public function getFilmElementAttribute($value)
  {
    return $value===null ? $this->element : $value;
  }

  public function setFilmElementAttribute($value)
  {
    $this->element = $value;
  }

  public function getFilmBaseAttribute($value)
  {
    return $value===null ? $this->base : $value;
  }

  public function setFilmBaseAttribute($value)
  {
    $this->base = $value;
  }

  public function getFilmContentDescriptionAttribute($value)
  {
    return $value===null ? $this->contentDescription : $value;
  }

  public function setFilmContentDescriptionAttribute($value)
  {
    $this->contentDescription = $value;
  }
}


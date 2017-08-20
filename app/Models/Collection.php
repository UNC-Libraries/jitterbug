<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $fillable = array('id', 'name');

  public $incrementing = false;

  public function audioVisualItems()
  {
    return $this->hasMany('Jitterbug\Models\AudioVisualItem');
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
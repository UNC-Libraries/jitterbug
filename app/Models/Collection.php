<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Collection extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $fillable = array('id', 'name', 'collectionTypeId', 'archivalIdentifier');

  public $incrementing = false;

  public function audioVisualItems()
  {
    return $this->hasMany('Jitterbug\Models\AudioVisualItem');
  }

  public function collectionType()
  {
    return $this->belongsTo(CollectionType::class);
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
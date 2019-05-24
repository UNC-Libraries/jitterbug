<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $fillable = array('id', 'name', 'collectionTypeId');

  public $incrementing = false;

  public function audioVisualItems()
  {
    return $this->hasMany('Jitterbug\Models\AudioVisualItem');
  }

  public function collectionType()
  {
    return $this->belongsTo(CollectionType::class);
  }

  public function collectionTypeName()
  {
    $collectionType = $this->collectionType;
    $name = CollectionType::formattedName($collectionType);
    return $name;
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
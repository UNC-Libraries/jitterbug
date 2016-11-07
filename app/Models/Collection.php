<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model {
  use CamelCasing;

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
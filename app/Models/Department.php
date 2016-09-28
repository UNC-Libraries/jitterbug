<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {
  use CamelCasing;
    
  public function preservationMasters()
  {
     return $this->hasMany('Junebug\Models\PreservationMaster');
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
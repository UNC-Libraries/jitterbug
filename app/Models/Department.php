<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');
  
  protected $fillable = array('name');

  public function preservationMasters()
  {
     return $this->hasMany('Jitterbug\Models\PreservationMaster');
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }

  /**
   * Used by Revisionable when a related parent model has a null
   * foreign key value.
   */
  public function getRevisionNullString()
  {
    return 'nothing';
  }
}
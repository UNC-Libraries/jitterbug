<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class FilmTransfer extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  // Although there probably will be in the future, currently there 
  // are no fields on the film_transfers table beyond an id and timestamps. 
  // In order to avoid a MassAssignmentException when fields are filled in
  // the TransfersController, we need a $fillable array and at least one
  // element. The empty element can be removed once there is a meaningful
  // field populate.
  protected $fillable = array('');

  public function superclass()
  {
    return $this->morphOne('Transfer', 'subclass')->withTrashed();
  }

}
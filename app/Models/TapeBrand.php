<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;

class TapeBrand extends Model {
	use CamelCasing;

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;

class PlaybackMachine extends Model {
  use CamelCasing;

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
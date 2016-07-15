<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class Collection extends Model {
  use CamelCaseModel;

  public function audioVisualItems()
  {
    return $this->hasMany('Junebug\Models\AudioVisualItem');
  }

  public function legacy()
  {
    return $this->legacy == 1;
  }
  
  public function hasCallNumberException($prefix)
  {
    $exceptions = array();
    if($this->callNumberExceptions != null) {
      $exceptions = explode(',', $this->callNumberExceptions);
    }
    return in_array($prefix , $exceptions);
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
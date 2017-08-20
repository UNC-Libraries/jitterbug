<?php namespace Jitterbug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $fillable = array('name', 'prefix', 'legacyPrefix');

  // Filters out formats that will not be used for new items
  public function scopeWithFutureUse($query)
  {
    return $query->where('prefix', '<>', 'D')->
                   where('prefix', '<>', 'DDVD');
    }

  public function audioVisualItems()
  {
    return $this->hasMany('Jitterbug\Models\AudioVisualItem');
  }

  public function identifiableName()
  {
    return $this->name;
  }
}
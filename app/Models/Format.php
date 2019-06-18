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
    return $this->hasMany(AudioVisualItem::class);
  }

  public function prefixes()
  {
    return $this->belongsToMany(Prefix::class);
  }

  public function uniquePrefixLabels()
  {
    return $this->prefixes->unique('label')->pluck('label')->all();
  }

  public function identifiableName()
  {
    return $this->name;
  }

  public function detachPrefixes($prefixIds)
  {
    $this->prefixes()->detach($prefixIds);
  }
}
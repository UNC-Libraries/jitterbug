<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionType extends Model
{
  use SoftDeletes;

  protected $fillable = array('name');

  public function collections()
  {
    return $this->hasMany(Collection::class);
  }

  public function prefixes()
  {
    return $this->hasMany(Prefix::class);
  }

}
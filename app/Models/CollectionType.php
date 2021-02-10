<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectionType extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected $fillable = array('name');

  public function collections()
  {
    return $this->hasMany(Collection::class);
  }

  public function prefixes()
  {
    return $this->hasMany(Prefix::class);
  }

  public static function arrayForSelect()
  {
    return self::pluck('name','id')->toArray();
  }

  public static function formattedName($collectionType)
  {
    return $collectionType === null ? '--' : $collectionType->name;
  }
}

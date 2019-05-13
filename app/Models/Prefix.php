<?php


namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefix extends Model
{
  use SoftDeletes;

  protected $fillable = array('label', 'legacy', 'collectionTypeId');

  public function collectionType()
  {
    return $this->belongsTo(CollectionType::class);
  }

  public function formats()
  {
    return $this->belongsToMany(Format::class);
  }

  public function detachAllFormats()
  {
    $this->formats()->detach();
  }

  public function collectionTypeName()
  {
    return $this->collectionType->name;
  }
}

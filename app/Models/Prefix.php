<?php


namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefix extends Model
{
  use SoftDeletes;
  use CamelCasing;

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
    $collectionType= $this->collectionType;
    return CollectionType::formattedName($collectionType);
  }
}

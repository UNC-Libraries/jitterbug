<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

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
        return self::pluck('name', 'id')->toArray();
    }

    public static function formattedName($collectionType)
    {
        return $collectionType === null ? '--' : $collectionType->name;
    }
}

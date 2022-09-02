<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use NullFieldPreserver;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['name', 'collection_type_id', 'archival_identifier'];

    public function audioVisualItems()
    {
        return $this->hasMany(\Jitterbug\Models\AudioVisualItem::class);
    }

    public function collectionType()
    {
        return $this->belongsTo(CollectionType::class);
    }

    /**
     * Used by Revisionable to get a display name for the model.
     */
    public function identifiableName()
    {
        return $this->name;
    }
}

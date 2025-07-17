<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use NullFieldPreserver;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function preservationInstances(): HasMany
    {
        return $this->hasMany(\Jitterbug\Models\PreservationInstance::class);
    }

    /**
     * Used by Revisionable to get a display name for the model.
     */
    public function identifiableName()
    {
        return $this->name;
    }

    /**
     * Used by Revisionable when a related parent model has a null
     * foreign key value.
     */
    public function getRevisionNullString()
    {
        return 'nothing';
    }
}

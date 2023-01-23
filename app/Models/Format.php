<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Format extends Model
{
    use NullFieldPreserver;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['name', 'prefix', 'legacy_prefix'];

    // Filters out formats that will not be used for new items
    public function scopeWithFutureUse($query)
    {
        return $query->where('id', '<>', 25)
                 ->where('id', '<>', 54);
    }

    public function audioVisualItems()
    {
        return $this->hasMany(AudioVisualItem::class);
    }

    public function prefixes()
    {
        return $this->belongsToMany(Prefix::class)->withTimestamps();
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
        // prefixIds may be: an integer, an array of IDs, or null (which will detach all prefixes)
        $this->prefixes()->detach($prefixIds);
    }

    public function attachPrefixes($prefixIds)
    {
        // prefixIds may be: an integer or an array of IDs
        $this->prefixes()->attach($prefixIds);
    }
}

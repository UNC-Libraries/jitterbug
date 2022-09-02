<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class FilmItem extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use SoftDeletes;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'element' => 'isEmpty:nothing|%s',
        'base' => 'isEmpty:nothing|%s',
        'color' => 'isEmpty:nothing|%s',
        'sound_type' => 'isEmpty:nothing|%s',
        'length_in_feet' => 'isEmpty:nothing|%s',
        'film_stock' => 'isEmpty:nothing|%s',
        'edge_code' => 'isEmpty:nothing|%s',
        'shrinkage_percent' => 'isEmpty:nothing|%s',
        'can_number' => 'isEmpty:nothing|%s',
        'condition' => 'isEmpty:nothing|%s',
        'content_description' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'call_number' => 'call number',
        'sound_type' => 'sound type',
        'length_in_feet' => 'length in feet',
        'film_stock' => 'film stock',
        'edge_code' => 'edge code',
        'shrinkage_percent' => 'shrinkage percent',
        'can_number' => 'can number',
        'content_description' => 'content description',
    ];

    protected $fillable = ['call_number', 'film_element', 'film_base',
        'film_color', 'sound_type', 'length_in_feet', 'film_stock', 'edge_code',
        'shrinkage_percent', 'can_number', 'condition', 'film_content_description', ];

    public function superclass()
    {
        return $this->morphOne('AudioVisualItem', 'subclass')->withTrashed();
    }

    public function getFilmColorAttribute($value)
    {
        return $value === null ? $this->color : $value;
    }

    public function setFilmColorAttribute($value)
    {
        $this->color = $value;
    }

    public function getFilmElementAttribute($value)
    {
        return $value === null ? $this->element : $value;
    }

    public function setFilmElementAttribute($value)
    {
        $this->element = $value;
    }

    public function getFilmBaseAttribute($value)
    {
        return $value === null ? $this->base : $value;
    }

    public function setFilmBaseAttribute($value)
    {
        $this->base = $value;
    }

    public function getFilmContentDescriptionAttribute($value)
    {
        return $value === null ? $this->content_description : $value;
    }

    public function setFilmContentDescriptionAttribute($value)
    {
        $this->content_description = $value;
    }
}

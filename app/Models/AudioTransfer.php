<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioTransfer extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use SoftDeletes;
    use HasFactory;

    protected $revisionCreationsEnabled = true;

    public function superclass()
    {
        return $this->morphOne('Transfer', 'subclass')->withTrashed();
    }

    protected $revisionFormattedFields = [
        'stylus' => 'isEmpty:nothing|%s',
        'cartridge' => 'isEmpty:nothing|%s',
        'first_sound' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'first_sound' => 'first sound',
    ];

    protected $fillable = ['stylus',
        'cartridge', 'first_sound', ];
}

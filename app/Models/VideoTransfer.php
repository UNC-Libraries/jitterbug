<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class VideoTransfer extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use SoftDeletes;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'time_base_corrector' => 'isEmpty:nothing|%s',
        'ad_converter' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'time_base_corrector' => 'time base corrector',
        'ad_converter' => 'A/D converter',
    ];

    protected $fillable = ['time_base_corrector',
        'ad_converter', ];

    public function superclass()
    {
        return $this->morphOne('Transfer', 'subclass')->withTrashed();
    }
}

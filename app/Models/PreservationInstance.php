<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jitterbug\Util\DurationFormat;
use Venturecraft\Revisionable\RevisionableTrait;

class PreservationInstance extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use CompositeHistory;
    use SoftDeletes;
    use Markable;
    use HasFactory;

    const BATCH_EDIT_MAX_LIMIT = 1000;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'checksum' => 'isEmpty:nothing|%s',
        'project_id' => 'isEmpty:nothing|%s',
        'reproduction_machine_id' => 'isEmpty:nothing|%s',
        'department_id' => 'isEmpty:nothing|%s',
        'duration_in_seconds' => 'isEmpty:nothing|%s',
        'file_name' => 'isEmpty:nothing|%s',
        'file_location' => 'isEmpty:nothing|%s',
        'file_format' => 'isEmpty:nothing|%s',
        'file_codec' => 'isEmpty:nothing|%s',
        'file_size_in_bytes' => 'isEmpty:nothing|%s',
        'access_file_location' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'call_number' => 'call number',
        'reproduction_machine_id' => 'reproduction machine',
        'duration_in_seconds' => 'duration',
        'file_name' => 'file name',
        'file_location' => 'file location',
        'file_format' => 'file format',
        'file_codec' => 'file codec',
        'file_size_in_bytes' => 'file size',
        'access_file_location' => 'access file location',
    ];

    protected $fillable = ['call_number', 'checksum',
        'project_id', 'reproduction_machine_id', 'department_id',
        'duration', 'file_name', 'file_location',
        'file_size_in_bytes', 'audio_file_format', 'audio_file_codec',
        'film_file_format', 'film_file_codec', 'video_file_format',
        'video_file_codec', 'access_file_location', ];

    public function __construct($attributes = [])
    {
        $this->subclass_type = 'AudioInstance';
        parent::__construct($attributes);
    }

    public function batch()
    {
        return false;
    }

    public function item()
    {
        return $this->belongsTo(\Jitterbug\Models\AudioVisualItem::class, 'call_number', 'call_number');
    }

    public function cuts()
    {
        return $this->hasMany(\Jitterbug\Models\Cut::class);
    }

    public function transfers()
    {
        return $this->hasMany(\Jitterbug\Models\Transfer::class);
    }

    public function department()
    {
        return $this->belongsTo(\Jitterbug\Models\Department::class);
    }

    public function project()
    {
        return $this->belongsTo(\Jitterbug\Models\Project::class);
    }

    public function reproductionMachine()
    {
        return $this->belongsTo(\Jitterbug\Models\ReproductionMachine::class);
    }

    public function subclass()
    {
        return $this->morphTo();
    }

    public function getBatchAttribute()
    {
        return $this->batch();
    }

    public function getTypeAttribute()
    {
        $fullType = $this->subclass_type;
        $type = substr($fullType, 0, strlen($fullType) - strlen('Instance'));

        return $type;
    }

    public function getTypeIdAttribute()
    {
        // Rather than doing a query, we'll just return hardcoded values
        $type = $this->getAttribute('type');
        if ($type === 'Audio') {
            return 1;
        } elseif ($type === 'Film') {
            return 2;
        } elseif ($type === 'Video') {
            return 3;
        }
    }

    /* File format accessors / mutators */

    public function getAudioFileFormatAttribute($value)
    {
        if ($this->subclass_type === 'AudioInstance') {
            return $value === null ? $this->file_format : $value;
        }
    }

    public function setAudioFileFormatAttribute($value)
    {
        if ($this->subclass_type === 'AudioInstance') {
            $this->file_format = $value;
        }
    }

    public function getFilmFileFormatAttribute($value)
    {
        if ($this->subclass_type === 'FilmInstance') {
            return $value === null ? $this->file_format : $value;
        }
    }

    public function setFilmFileFormatAttribute($value)
    {
        if ($this->subclass_type === 'FilmInstance') {
            $this->file_format = $value;
        }
    }

    public function getVideoFileFormatAttribute($value)
    {
        if ($this->subclass_type === 'VideoInstance') {
            return $value === null ? $this->file_format : $value;
        }
    }

    public function setVideoFileFormatAttribute($value)
    {
        if ($this->subclass_type === 'VideoInstance') {
            $this->file_format = $value;
        }
    }

    /* File codec accessors / mutators */

    public function getAudioFileCodecAttribute($value)
    {
        if ($this->subclass_type === 'AudioInstance') {
            return $value === null ? $this->file_codec : $value;
        }
    }

    public function setAudioFileCodecAttribute($value)
    {
        if ($this->subclass_type === 'AudioInstance') {
            $this->file_codec = $value;
        }
    }

    public function getFilmFileCodecAttribute($value)
    {
        if ($this->subclass_type === 'FilmInstance') {
            return $value === null ? $this->file_codec : $value;
        }
    }

    public function setFilmFileCodecAttribute($value)
    {
        if ($this->subclass_type === 'FilmInstance') {
            $this->file_codec = $value;
        }
    }

    public function getVideoFileCodecAttribute($value)
    {
        if ($this->subclass_type === 'VideoInstance') {
            return $value === null ? $this->file_codec : $value;
        }
    }

    public function setVideoFileCodecAttribute($value)
    {
        if ($this->subclass_type === 'VideoInstance') {
            $this->file_codec = $value;
        }
    }

    public function getDurationAttribute()
    {
        return DurationFormat::toDuration($this->duration_in_seconds);
    }

    public function setDurationAttribute($value)
    {
        $this->duration_in_seconds = DurationFormat::toSeconds($value);
    }

    public function getDurationInSecondsDisplayAttribute($value = null)
    {
        $duration = $value ?? $this->duration_in_seconds;

        return DurationFormat::toDuration($duration);
    }
}

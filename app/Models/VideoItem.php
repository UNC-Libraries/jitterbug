<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class VideoItem extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use SoftDeletes;
    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'element' => 'isEmpty:nothing|%s',
        'color' => 'isEmpty:nothing|%s',
        'mono_stereo' => 'isEmpty:nothing|%s',
        'content_description' => 'isEmpty:nothing|%s',
        'recording_standard' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'call_number' => 'call number',
        'element' => 'element',
        'color' => 'color',
        'mono_stereo' => 'mono/stereo',
        'content_description' => 'content description',
        'recording_standard' => 'recording standard',
    ];

    protected $fillable = ['call_number', 'video_element',
        'video_color', 'video_mono_stereo',
        'video_content_description', 'recording_standard', ];

    public function superclass()
    {
        return $this->morphOne('AudioVisualItem', 'subclass')->withTrashed();
    }

    public function getMonoStereoDisplayAttribute($value)
    {
        $monoStereo = ($value == null ? $this->mono_stereo : $value);
        if ($monoStereo == 'M') {
            $monoStereo = 'Mono';
        } elseif ($monoStereo == 'S') {
            $monoStereo = 'Stereo';
        } else {
            $monoStereo = '';
        }

        return $monoStereo;
    }

    public function getMonoStereoAttribute($value)
    {
        if ($value == null) {
            return '';
        }

        return $value;
    }

    public function getVideoColorAttribute($value)
    {
        return $value == null ? $this->color : $value;
    }

    public function setVideoColorAttribute($value)
    {
        $this->color = $value;
    }

    public function getVideoElementAttribute($value)
    {
        return $value == null ? $this->element : $value;
    }

    public function setVideoElementAttribute($value)
    {
        $this->element = $value;
    }

    public function getVideoMonoStereoAttribute($value)
    {
        return $value == null ? $this->mono_stereo : $value;
    }

    public function setVideoMonoStereoAttribute($value)
    {
        $this->mono_stereo = $value;
    }

    public function getVideoContentDescriptionAttribute($value)
    {
        return $value == null ? $this->content_description : $value;
    }

    public function setVideoContentDescriptionAttribute($value)
    {
        $this->content_description = $value;
    }
}

<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class VideoInstance extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use SoftDeletes;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'frame_size' => 'isEmpty:nothing|%s',
        'aspect_ratio' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'frame_size' => 'frame size',
        'aspect_ratio' => 'aspect ratio',
    ];

    protected $fillable = ['video_frame_size', 'video_aspect_ratio'];

    public function superclass()
    {
        return $this->morphOne('PreservationInstance', 'subclass')->withTrashed();
    }

    public function getVideoFrameSizeAttribute($value)
    {
        return $value === null ? $this->frame_size : $value;
    }

    public function setVideoFrameSizeAttribute($value)
    {
        $this->frame_size = $value;
    }

    public function getVideoAspectRatioAttribute($value)
    {
        return $value === null ? $this->aspect_ratio : $value;
    }

    public function setVideoAspectRatioAttribute($value)
    {
        $this->aspect_ratio = $value;
    }
}

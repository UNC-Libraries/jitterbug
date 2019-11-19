<?php namespace Jitterbug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

use Jitterbug\Util\DurationFormat;

class PreservationMaster extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use CompositeHistory;
  use SoftDeletes;
  use Markable;

  const BATCH_EDIT_MAX_LIMIT = 1000;

  protected $dates = ['deleted_at'];
  
  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
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
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'reproduction_machine_id' => 'reproduction machine',
    'duration_in_seconds' => 'duration',
    'file_name' => 'file name',
    'file_location' => 'file location',
    'file_format' => 'file format',
    'file_codec' => 'file codec',
    'file_size_in_bytes' => 'file size',
    'access_file_location' => 'access file location',
  );

  protected $fillable = array('call_number', 'checksum',
    'project_id', 'reproduction_machine_id', 'department_id',
    'duration', 'file_name', 'file_location',
    'file_size_in_bytes', 'audio_file_format', 'audio_file_codec',
    'film_file_format', 'film_file_codec', 'video_file_format',
    'video_file_codec', 'access_file_location');

  public function __construct($attributes = [])
  {
    $this->subclass_type = 'AudioMaster';
    parent::__construct($attributes);
  }

  public function batch()
  {
    return false;
  }

  public function item()
  {
    return $this->belongsTo('Jitterbug\Models\AudioVisualItem', 'call_number', 'call_number');
  }

  public function cuts()
  {
    return $this->hasMany('Jitterbug\Models\Cut');
  }

  public function transfers()
  {
    return $this->hasMany('Jitterbug\Models\Transfer');
  }

  public function department()
  {
    return $this->belongsTo('Jitterbug\Models\Department');
  }

  public function project()
  {
    return $this->belongsTo('Jitterbug\Models\Project');
  }

  public function reproductionMachine()
  {
    return $this->belongsTo('Jitterbug\Models\ReproductionMachine');
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
    $type = substr($fullType, 0, strlen($fullType) - strlen("Master"));
    return $type;
  }

  public function getTypeIdAttribute()
  {
    // Rather than doing a query, we'll just return hardcoded values
    $type = $this->getAttribute("type");
    if($type==='Audio') {
      return 1;
    } else if ($type==='Film') {
      return 2;
    } else if ($type==='Video') {
      return 3;
    }
  }
  
  /* File format accessors / mutators */

  public function getAudioFileFormatAttribute($value)
  {
    if ($this->subclass_type === 'AudioMaster') {
      return $value===null ? $this->file_format : $value;
    }
  }

  public function setAudioFileFormatAttribute($value)
  {
    if ($this->subclass_type === 'AudioMaster') {
      $this->file_format = $value;
    }
  }

  public function getFilmFileFormatAttribute($value)
  {
    if ($this->subclass_type === 'FilmMaster') {
      return $value===null ? $this->file_format : $value;
    }
  }

  public function setFilmFileFormatAttribute($value)
  {
    if ($this->subclass_type === 'FilmMaster') {
      $this->file_format = $value;
    }
  }

  public function getVideoFileFormatAttribute($value)
  {
    if ($this->subclass_type === 'VideoMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setVideoFileFormatAttribute($value)
  {
    if ($this->subclass_type === 'VideoMaster') {
      $this->fileFormat = $value;
    }
  }

  /* File codec accessors / mutators */

  public function getAudioFileCodecAttribute($value)
  {
    if ($this->subclass_type === 'AudioMaster') {
      return $value===null ? $this->file_codec : $value;
    }
  }

  public function setAudioFileCodecAttribute($value)
  {
    if ($this->subclass_type === 'AudioMaster') {
      $this->file_codec = $value;
    }
  }

  public function getFilmFileCodecAttribute($value)
  {
    if ($this->subclass_type === 'FilmMaster') {
      return $value===null ? $this->file_codec : $value;
    }
  }

  public function setFilmFileCodecAttribute($value)
  {
    if ($this->subclass_type === 'FilmMaster') {
      $this->file_codec = $value;
    }
  }

  public function getVideoFileCodecAttribute($value)
  {
    if ($this->subclass_type === 'VideoMaster') {
      return $value===null ? $this->file_codec : $value;
    }
  }

  public function setVideoFileCodecAttribute($value)
  {
    if ($this->subclass_type === 'VideoMaster') {
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
  
  public function getDurationInSecondsDisplayAttribute()
  {
    return DurationFormat::toDuration($this->duration_in_seconds);
  }
}


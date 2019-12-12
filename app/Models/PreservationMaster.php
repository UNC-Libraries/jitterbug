<?php namespace Jitterbug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

use Jitterbug\Util\DurationFormat;

class PreservationMaster extends Model {
  use CamelCasing;
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

  protected $fillable = array('callNumber', 'checksum',
    'projectId', 'reproductionMachineId', 'departmentId', 
    'duration', 'fileName', 'fileLocation', 
    'fileSizeInBytes', 'audioFileFormat', 'audioFileCodec',
    'filmFileFormat', 'filmFileCodec', 'videoFileFormat',
    'videoFileCodec', 'accessFileLocation');

  public function __construct($attributes = [])
  {
    $this->subclassType = 'AudioMaster';
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
    $fullType = $this->subclassType;
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
    if ($this->subclassType === 'AudioMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setAudioFileFormatAttribute($value)
  {
    if ($this->subclassType === 'AudioMaster') {
      $this->fileFormat = $value;
    }
  }

  public function getFilmFileFormatAttribute($value)
  {
    if ($this->subclassType === 'FilmMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setFilmFileFormatAttribute($value)
  {
    if ($this->subclassType === 'FilmMaster') {
      $this->fileFormat = $value;
    }
  }

  public function getVideoFileFormatAttribute($value)
  {
    if ($this->subclassType === 'VideoMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setVideoFileFormatAttribute($value)
  {
    if ($this->subclassType === 'VideoMaster') {
      $this->fileFormat = $value;
    }
  }

  /* File codec accessors / mutators */

  public function getAudioFileCodecAttribute($value)
  {
    if ($this->subclassType === 'AudioMaster') {
      return $value===null ? $this->fileCodec : $value;
    }
  }

  public function setAudioFileCodecAttribute($value)
  {
    if ($this->subclassType === 'AudioMaster') {
      $this->fileCodec = $value;
    }
  }

  public function getFilmFileCodecAttribute($value)
  {
    if ($this->subclassType === 'FilmMaster') {
      return $value===null ? $this->fileCodec : $value;
    }
  }

  public function setFilmFileCodecAttribute($value)
  {
    if ($this->subclassType === 'FilmMaster') {
      $this->fileCodec = $value;
    }
  }

  public function getVideoFileCodecAttribute($value)
  {
    if ($this->subclassType === 'VideoMaster') {
      return $value===null ? $this->fileCodec : $value;
    }
  }

  public function setVideoFileCodecAttribute($value)
  {
    if ($this->subclassType === 'VideoMaster') {
      $this->fileCodec = $value;
    }
  }

  public function getDurationAttribute()
  {
    return DurationFormat::toDuration($this->durationInSeconds);
  }

  public function setDurationAttribute($value)
  {
    $this->durationInSeconds = DurationFormat::toSeconds($value);
  }
  
  public function getDurationInSecondsDisplayAttribute()
  {
    return DurationFormat::toDuration($this->durationInSeconds);
  }
}


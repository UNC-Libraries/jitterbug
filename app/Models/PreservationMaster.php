<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

use Junebug\Util\DurationFormat;

class PreservationMaster extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use CompositeHistory;
  use SoftDeletes;

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
    'access_file_location' => 'access file location',
  );

  protected $fillable = array('callNumber', 'checksum',
    'projectId', 'reproductionMachineId', 'departmentId', 
    'duration', 'fileName', 'fileLocation', 
    'fileSizeInBytes', 'audioFileFormat', 'audioFileCode',
    'filmFileFormat', 'filmFileCodec', 'videoFileFormat',
    'videoFileCodec', 'accessFileLocation');

  public function __construct()
  {
    $this->masterableType = 'AudioMaster';
    parent::__construct();
  }

  public function batch()
  {
    return false;
  }

  public function cuts()
  {
    return $this->hasMany('Junebug\Models\Cut');
  }

  public function transfers()
  {
    return $this->hasMany('Junebug\Models\Transfer');
  }

  public function department()
  {
    return $this->belongsTo('Junebug\Models\Department');
  }

  public function project()
  {
    return $this->belongsTo('Junebug\Models\Project');
  }

  public function masterable()
  {
    return $this->morphTo();
  }

  public function getBatchAttribute()
  {
    return $this->batch();
  }
  
  public function getTypeAttribute()
  {
  	$fullType = $this->getAttribute("masterableType");
    $type = substr($fullType,0,strlen($fullType)
    	- strlen("Master"));
    return $type;
  }

  /* File format accessors / mutators */

  public function getAudioFileFormatAttribute($value)
  {
    if ($this->masterableType === 'AudioMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setAudioFileFormatAttribute($value)
  {
    if ($this->masterableType === 'AudioMaster') {
      $this->fileFormat = $value;
    }
  }

  public function getFilmFileFormatAttribute($value)
  {
    if ($this->masterableType === 'FilmMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setFilmFileFormatAttribute($value)
  {
    if ($this->masterableType === 'FilmMaster') {
      $this->fileFormat = $value;
    }
  }

  public function getVideoFileFormatAttribute($value)
  {
    if ($this->masterableType === 'VideoMaster') {
      return $value===null ? $this->fileFormat : $value;
    }
  }

  public function setVideoFileFormatAttribute($value)
  {
    if ($this->masterableType === 'VideoMaster') {
      $this->fileFormat = $value;
    }
  }

  /* File codec accessors / mutators */

  public function getAudioFileCodecAttribute($value)
  {
    if ($this->masterableType === 'AudioMaster') {
      return $value===null ? $this->fileCodec : $value;
    }
  }

  public function setAudioFileCodecAttribute($value)
  {
    if ($this->masterableType === 'AudioMaster') {
      $this->fileCodec = $value;
    }
  }

  public function getFilmFileCodecAttribute($value)
  {
    if ($this->masterableType === 'FilmMaster') {
      return $value===null ? $this->fileCodec : $value;
    }
  }

  public function setFilmFileCodecAttribute($value)
  {
    if ($this->masterableType === 'FilmMaster') {
      $this->fileCodec = $value;
    }
  }

  public function getVideoFileCodecAttribute($value)
  {
    if ($this->masterableType === 'VideoMaster') {
      return $value===null ? $this->fileCodec : $value;
    }
  }

  public function setVideoFileCodecAttribute($value)
  {
    if ($this->masterableType === 'VideoMaster') {
      $this->fileCodec = $value;
    }
  }

  public function getDurationAttribute()
  {
    $durationInSeconds = $this->getAttribute("durationInSeconds");
    return DurationFormat::toDuration($durationInSeconds);
  }

  public function setDurationAttribute($value)
  {
    $this->durationInSeconds = DurationFormat::toSeconds($value);
  }
  
}


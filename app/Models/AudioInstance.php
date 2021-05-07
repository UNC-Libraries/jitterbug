<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioMaster extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;
  use HasFactory;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'tape_brand_id' => 'isEmpty:nothing|%s',
    'pm_speed_id' => 'isEmpty:nothing|%s',
    'sampling_rate_id' => 'isEmpty:nothing|%s',
    'test_tones' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'tape_brand_id' => 'tape brand',
    'pm_speed_id' => 'PM speed',
    'sampling_rate_id' => 'sampling rate',
    'test_tones' => 'test tones',
  );

  protected $fillable = array('tape_brand_id', 'pm_speed_id',
    'sampling_rate_id', 'test_tones');

  public function superclass()
  {
    return $this->morphOne('PreservationMaster', 'subclass')->withTrashed();
  }

  public function tapeBrand()
  {
    return $this->belongsTo('Jitterbug\Models\TapeBrand');
  }

  public function pmSpeed()
  {
    return $this->belongsTo('Jitterbug\Models\PmSpeed');
  }

  public function samplingRate()
  {
    return $this->belongsTo('Jitterbug\Models\SamplingRate');
  }

}
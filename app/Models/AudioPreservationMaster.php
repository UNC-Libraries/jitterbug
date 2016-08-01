<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioPreservationMaster extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  public function tapeBrand()
  {
    return $this->belongsTo('Junebug\Models\TapeBrand');
  }

  public function pmSpeed()
  {
    return $this->belongsTo('Junebug\Models\PmSpeed');
  }

  public function samplingRate()
  {
    return $this->belongsTo('Junebug\Models\SamplingRate');
  }

}
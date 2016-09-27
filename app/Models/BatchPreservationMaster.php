<?php namespace Junebug\Models;

use Log;

use Junebug\Models\PreservationMaster;
use Junebug\Util\DurationFormat;

class BatchPreservationMaster extends PreservationMaster {
  use MergeableAttributes;

  protected $masters;
  protected $masterables;
  protected $aggregateMaster;
  protected $aggregateMasterable;

  protected $batchGuarded = ['id', 'masterableType', 'masterableId', 'createdAt',
    'updatedAt'];

  protected $attributes;

  public function __construct($masters, $masterables)
  {
    parent::__construct();

    $this->masters = $masters;
    $this->masterables = $masterables;

    $this->aggregateMaster = new PreservationMaster;
    $masterableType = $this->masters->first()->masterableType;
    $this->aggregateMaster->masterableType = $masterableType;
    $this->aggregateMasterable = new $masterableType;
    $this->mergeAttributes($masters, $this->aggregateMaster);
    $this->mergeAttributes($masterables, $this->aggregateMasterable);

    $this->attributes = $this->aggregateMaster->attributes;
  }

  public function batch()
  {
    return true;
  }

  public function getDurationAttribute()
  {
    if ($this->durationInSeconds==='<mixed>') {
      return $this->durationInSeconds;
    } else {
      return DurationFormat::toDuration($this->durationInSeconds);
    }
  }

  public function getIdsAttribute()
  {
    $ids = array();
    foreach($this->masters as $master) {
      array_push($ids, $master->id);
    }
    return implode(',', $ids);
  }

  public function getMasterableAttribute()
  {
    return $this->aggregateMasterable;
  }

  public function masterable()
  {
    return $this->aggregateMasterable;
  }

  public function getTypeAttribute()
  {
    $fullType = $this->masters->first()->getAttribute("masterableType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Master"));
    return $type;
  }

  public function count()
  {
    return $this->masters->count();
  }

}

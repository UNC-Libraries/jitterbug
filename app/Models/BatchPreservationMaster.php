<?php namespace Junebug\Models;

use Log;

use Junebug\Models\PreservationMaster;
use Junebug\Util\DurationFormat;

class BatchPreservationMaster extends PreservationMaster {
  use MergeableAttributes;

  protected $masters;
  protected $subclasses;
  protected $aggregateMaster;
  protected $aggregateSubclass;

  protected $batchGuarded = ['id', 'subclassType', 'subclassId', 'createdAt',
    'updatedAt'];

  protected $attributes;

  public function __construct($masters, $subclasses)
  {
    parent::__construct();

    $this->masters = $masters;
    $this->subclasses = $subclasses;

    $this->aggregateMaster = new PreservationMaster;
    $subclassType = $this->masters->first()->subclassType;
    $this->aggregateMaster->subclassType = $subclassType;
    $this->aggregateSubclass = new $subclassType;
    $this->mergeAttributes($masters, $this->aggregateMaster);
    $this->mergeAttributes($subclasses, $this->aggregateSubclass);

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

  public function getSubclassAttribute()
  {
    return $this->aggregateSubclass;
  }

  public function subclass()
  {
    return $this->aggregateSubclass;
  }

  public function getTypeAttribute()
  {
    $fullType = $this->masters->first()->getAttribute("subclassType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Master"));
    return $type;
  }

  public function count()
  {
    return $this->masters->count();
  }

}

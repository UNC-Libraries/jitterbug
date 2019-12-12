<?php namespace Jitterbug\Models;

use Log;

use Jitterbug\Models\PreservationMaster;
use Jitterbug\Util\DurationFormat;

class BatchPreservationMaster extends PreservationMaster {
  use MergeableAttributes;

  protected $masters;
  protected $subclasses;
  protected $aggregateMaster;
  protected $aggregateSubclass;

  protected $batchGuarded = ['id', 'subclass_type', 'subclass_id', 'created_at',
    'updated_at'];

  protected $attributes;

  public function __construct($masters, $subclasses)
  {
    parent::__construct();

    $this->masters = $masters;
    $this->subclasses = $subclasses;

    $this->aggregateMaster = new PreservationMaster;
    $subclassType = $this->masters->first()->subclass_type;
    $this->aggregateMaster->subclass_type = $subclassType;
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
    if ($this->duration_in_seconds==='<mixed>') {
      return $this->duration_in_seconds;
    } else {
      return DurationFormat::toDuration($this->duration_in_seconds);
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
    $fullType = $this->masters->first()->getAttribute('subclass_type');
    $type = substr($fullType,0,strlen($fullType) - strlen('Master'));
    return $type;
  }

  public function count()
  {
    return $this->masters->count();
  }

}

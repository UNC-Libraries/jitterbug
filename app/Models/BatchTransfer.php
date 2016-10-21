<?php namespace Junebug\Models;

use Log;

use Junebug\Models\Transfer;

class BatchTransfer extends Transfer {
  use MergeableAttributes;

  protected $transfers;
  protected $subclasses;
  protected $aggregateTranfer;
  protected $aggregateSubclass;

  protected $batchGuarded = ['id', 'subclassType', 'subclassId', 'createdAt',
    'updatedAt'];

  protected $attributes;

  public function __construct($transfers, $subclasses)
  {
    parent::__construct();

    $this->transfers = $transfers;
    $this->subclasses = $subclasses;

    $this->aggregateTransfer = new Transfer;
    $subclassType = $this->transfers->first()->subclassType;
    $this->aggregateTransfer->subclassType = $subclassType;
    $this->aggregateSubclass = new $subclassType;
    $this->mergeAttributes($transfers, $this->aggregateTransfer);
    $this->mergeAttributes($subclasses, $this->aggregateSubclass);

    $this->attributes = $this->aggregateTransfer->attributes;
  }

  public function batch()
  {
    return true;
  }

  public function getIdsAttribute()
  {
    $ids = array();
    foreach($this->transfers as $transfer) {
      array_push($ids, $transfer->id);
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
    $fullType = $this->transfers->first()->getAttribute("subclassType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Transfer"));
    return $type;
  }

  public function count()
  {
    return $this->transfers->count();
  }

}

<?php namespace Jitterbug\Models;

use Log;

use Jitterbug\Models\AudioVisualItem;

class BatchAudioVisualItem extends AudioVisualItem {
  use MergeableAttributes;

  protected $items;
  protected $subclasses;
  protected $aggregateItem;
  protected $aggregateSubclass;

  protected $batchGuarded = ['id', 'subclassType', 'subclassId', 'createdAt',
    'updatedAt'];

  protected $attributes;

  public function __construct($items, $subclasses)
  {
    parent::__construct();

    $this->items = $items;
    $this->subclasses = $subclasses;

    $this->aggregateItem = new AudioVIsualItem;
    $this->aggregateItem->entryDate = null;
    $subclassType = $this->items->first()->subclassType;
    $this->aggregateItem->subclassType = $subclassType;
    $this->aggregateSubclass = new $subclassType;
    $this->mergeAttributes($items, $this->aggregateItem);
    $this->mergeAttributes($subclasses, $this->aggregateSubclass);

    $this->attributes = $this->aggregateItem->attributes;
  }

  public function batch()
  {
    return true;
  }

  public function getIdsAttribute()
  {
    $ids = array();
    foreach($this->items as $item) {
      array_push($ids, $item->id);
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
    $fullType = $this->items->first()->getAttribute("subclassType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Item"));
    return $type;
  }

  public function count()
  {
    return $this->items->count();
  }

}

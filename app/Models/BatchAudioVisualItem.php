<?php namespace Junebug\Models;

use Log;

use Junebug\Models\AudioVisualItem;

class BatchAudioVisualItem extends AudioVisualItem {

  protected $items;
  protected $itemables;
  protected $aggregateItem;
  protected $aggregateItemable;

  protected $batchGuarded = ['id', 'itemableType', 'itemableId', 'createdAt',
    'updatedAt'];

  protected $attributes;

  public function __construct($items, $itemables)
  {
    parent::__construct();

    $this->items = $items;
    $this->itemables = $itemables;

    $this->aggregateItem = new AudioVIsualItem();
    $this->aggregateItem->entryDate = null;
    $itemableType = $this->items->first()->itemableType;
    $this->aggregateItem->itemableType = $itemableType;
    $this->aggregateItemable = new $itemableType;
    $this->mergeAttributes($items, $this->aggregateItem);
    $this->mergeAttributes($itemables, $this->aggregateItemable);

    $this->attributes = $this->aggregateItem->attributes;
  }

  /**
   * Merge the attributes from each member of the collection into attributes
   * on the target. If values differ amongst members of the collection,
   * the attribute will be set to '<mixed>'.
   */
  protected function mergeAttributes($collection, &$target)
  {
    $attributeNames = array_keys($collection->first()->getAttributes());
    $memberIndex = 0;
    foreach($collection as $member) {
      foreach($attributeNames as $attribute) {
        if (!in_array($attribute, $this->batchGuarded)) {
          if (($target->$attribute===null || $target->$attribute==='')  && $memberIndex==0) {
            $target->$attribute = $member->$attribute;
          } else if ($target->$attribute !== $member->$attribute) {
            $target->$attribute = '<mixed>';
          }
        }
      }
      $memberIndex++;
    }
  }

  public function batch()
  {
    return true;
  }

  public function getIdsAttribute() {
    $ids = array();
    foreach($this->items as $item) {
      array_push($ids, $item->id);
    }
    return implode(',', $ids);
  }

  public function getItemableAttribute()
  {
    return $this->aggregateItemable;
  }

  public function itemable()
  {
    return $this->aggregateItemable;
  }

  public function getTypeAttribute()
  {
    $fullType = $this->items->first()->getAttribute("itemableType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Item"));
    return $type;
  }

  public function count()
  {
    return $this->items->count();
  }

}

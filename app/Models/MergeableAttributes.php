<?php namespace Jitterbug\Models;

use Log;


trait MergeableAttributes {

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
}
<?php namespace Jitterbug\Import;

use Illuminate\Support\MessageBag;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Department;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Vendor;

abstract class Import {

  abstract public function validate();

  abstract public function execute();

  public function data()
  {
    return $this->data;
  }

  public function count()
  {
    return count($this->data);
  }

  protected function valueExists($class, $columnName, $value)
  {
    return $class::where($columnName, $value)->first() !== null;
  }

  protected function pmExists($pmId)
  {
    return PreservationMaster::find($pmId) !== null;
  }

  protected function isValidDate($date)
  {
    $format = 'Y-m-d';
    return date($date) == date($format, strtotime($date));
  }

  public static function hasErrors($messageBags)
  {
    foreach($messageBags as $bag) {
      if ($bag->any()) {
        return true;
      }
    }
    return false;
  }

}

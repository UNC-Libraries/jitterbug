<?php namespace Jitterbug\Import;

use Illuminate\Support\MessageBag;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\PreservationMaster;

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

  protected function callNumberExists($callNumber)
  {
    return AudioVisualItem::where('call_number', 
      $callNumber)->first() !== null;
  }

  protected function fileNameExists($fileName)
  {
    return PreservationMaster::where('file_name', 
      $fileName)->first() !== null;
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

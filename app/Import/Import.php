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

  protected function departmentExists($department)
  {
    return Department::where('name', $department)->first() !== null;
  }

  protected function playbackMachineExists($playbackMachine)
  {
    return PlaybackMachine::where('name', 
      $playbackMachine)->first() !== null;
  }

  protected function vendorExists($vendor)
  {
    return Vendor::where('name', $vendor)->first() !== null;
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

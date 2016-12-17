<?php namespace Jitterbug\Presenters;

use Log;

use Junebug\Models\Mark;

/**
 * Decorates a Mark with functionality needed for the Dashboard.
 */
class DashboardMark
{

  private $mark;
  private $objectType;

  public function __construct($mark)
  {
    $this->mark = $mark;

    $class = $this->mark->markableType;
    $snakeClass = snake_case($class);
    $explodedClass = explode('_', $snakeClass);
    $this->objectType = array_pop($explodedClass);
  }

  /**
   * Instantiate an array of DashboardMarks from an iterable
   * collection of Marks.
   *
   * @return array
   */
  static public function fromMarks($marks)
  {
  	$dashboardMarks = array();
    foreach($marks as $mark) {
      array_push($dashboardMarks, new DashboardMark($mark));
    }
    return $dashboardMarks;
  }

  public function object()
  {
    $class = $this->mark->markableType;
    $instance = 
      $class::findOrFail($this->mark->markableId);
    $mediaType = $instance->type;

    if ($this->objectType === 'item') {
      return $mediaType . ' ' 
        . $this->objectType . ' ' 
        . $instance->callNumber;
    } else {
      return $mediaType . ' ' 
        . $this->objectType . ' ' 
        . 'for item '
        . $instance->callNumber;
    }
  }

  public function objectId()
  {
    return $this->mark->markableId;
  }

  public function objectType()
  {
    return $this->objectType;
  }
  
  public function timestamp()
  {
    return timeAgoInWords($this->mark->updatedAt);
  }
}
<?php namespace Junebug\Models;

use Log;

class TableSelection
{
  // Together, $begin and $end constitute a selection range
  private $begin;
  private $end;
  // Exclusions from the selection range
  private $excludes = [];
  // Inclusions outside the selection range
  private $includes = [];

  public function __construct($begin, $end, $excludes, $includes)
  {
    $this->begin = $begin;
    $this->end = $end;
    $this->excludes = $excludes;
    $this->includes = $includes;
  }

  /**
   * Find the minimum row index value including those in the includes
   * and excludes arrays.
   */
  public function indexMin()
  {
    $minExcludes = count($this->excludes) > 0 ? min($this->excludes) : null;
    $minIncludes = count($this->includes) > 0 ? min($this->includes) : null;
    $diff = array_diff(
     array($this->begin, $this->end, $minExcludes, $minIncludes), array(null));
    return min($diff);
  }

  /**
   * Find the maximum row index value including those in the includes
   * and excludes arrays.
   */
  public function indexMax()
  {
    $maxExcludes = count($this->excludes) > 0 ? max($this->excludes) : null;
    $maxIncludes = count($this->includes) > 0 ? max($this->includes) : null;
    $diff = array_diff(
     array($this->begin, $this->end, $maxExcludes, $maxIncludes), array(null));
    return max($diff);
  }

  /**
   * Calculates the total number of indices between the first occurence of an
   * index to the last.
   */
  public function indexCount()
  {
    return $this->indexMax() - $this->indexMin() + 1;
  }

  public function selectionCount()
  {
    $rangeCount;
    if ($this->begin===null) {
      $rangeCount = 0;
    } else {
      $rangeCount = $this->rangeMax() - $this->rangeMin() + 1;
    }
    $total = $rangeCount - count($this->excludes) + count($this->includes);
    return $total;
  }

  public function selected($index)
  {
    if (($this->inRange($index) && 
      in_array($index, $this->excludes) == false) || 
      in_array($index, $this->includes) == true) {
      return true;
    } else {
      return false;
    }
  }

  public function rangeMin()
  {
    return min($this->begin, $this->end);
  }

  public function rangeMax()
  {
    return max($this->begin, $this->end);
  }

  public function inRange($index)
  {
    if ($index >= $this->rangeMin() && 
      $index <= $this->rangeMax()) {
      return true;
    } else {
      return false;
    }
  }

}
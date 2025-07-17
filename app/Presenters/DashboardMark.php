<?php

namespace Jitterbug\Presenters;

use Westsworld\TimeAgo;

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

        $class = $this->mark->markable_type;
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
    public static function fromMarks($marks)
    {
        $dashboardMarks = [];
        foreach ($marks as $mark) {
            $dashboardMarks[] = new DashboardMark($mark);
        }

        return $dashboardMarks;
    }

    public function object()
    {
        $class = $this->mark->markable_type;
        $instance =
      $class::findOrFail($this->mark->markable_id);
        $mediaType = $instance->type;

        if ($this->objectType === 'item') {
            return $mediaType.' '
        .$this->objectType.' '
        .$instance->call_number;
        } else {
            return $mediaType.' '
        .$this->objectType.' '
        .'for item '
        .$instance->call_number;
        }
    }

    public function objectId()
    {
        return $this->mark->markable_id;
    }

    public function objectType()
    {
        return $this->objectType;
    }

    public function timestamp()
    {
        $timeAgo = new TimeAgo;

        return $timeAgo->inWordsFromStrings($this->mark->updated_at);
    }
}

<?php

namespace Jitterbug\Models;

trait Markable
{
    /**
     * Test if this object is marked by the user.
     */
    public function marked()
    {
        return $this->getMark() !== null;
    }

    /**
     * Create a new mark for this object for the current user.
     * Note: we can't call this method simply 'mark' because
     * that's apparently a method name in Laravel that is
     * called by the framework.
     */
    public function addMark()
    {
        $mark = $this->getMark();
        if ($mark === null) {
            $mark = new Mark;
            $mark->markable_type = class_basename(get_class($this));
            $mark->markable_id = $this->id;
            $mark->user_id = \Auth::user()->id;
        } else {
            $mark->touch();
        }
        $mark->save();
    }

    /**
     * Remove the mark for the current user from this object if
     * one exists.
     */
    public function removeMark()
    {
        $mark = $this->getMark();
        if ($mark !== null) {
            $mark->delete();
        }
    }

    /**
     * Remove all marks for all users from this object if any
     * exist.
     */
    public function removeAllMarks()
    {
        $marks = Mark::where('markable_type', class_basename(get_class($this)))
            ->where('markable_id', $this->id)->get();
        foreach ($marks as $mark) {
            $mark->delete();
        }
    }

    private function getMark()
    {
        return Mark::where('markable_type', class_basename(get_class($this)))
            ->where('markable_id', $this->id)
            ->where('user_id', \Auth::user()->id)->first();
    }
}

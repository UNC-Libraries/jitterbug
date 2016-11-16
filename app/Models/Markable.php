<?php namespace Jitterbug\Models;

use Log;

trait Markable
{
  public function marked()
  {
    return Mark::where('markable_type', get_class($this))
               ->where('markable_id', $this->id)
               ->where('user_id', \Auth::user()->id)->first() !== null;
  }
}
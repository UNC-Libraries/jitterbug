<?php namespace Junebug\Models;

use Log;

class LegacyCallNumberSequence extends CallNumberSequence {

  public function callNumber() {        
    return $this->prefix . '-' . $this->next;
  }

}
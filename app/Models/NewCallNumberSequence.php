<?php namespace Jitterbug\Models;

use Log;

class NewCallNumberSequence extends CallNumberSequence {

  public function callNumber() {
    return $this->prefix . '-' . $this->archival_identifier . '/' . $this->next;
  }
  
}
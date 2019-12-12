<?php namespace Jitterbug\Models;

use Log;

class NewCallNumberSequence extends CallNumberSequence {

  public function callNumber() {
    return $this->prefix . '-' . $this->archivalIdentifier . '/' . $this->next;
  }
  
}
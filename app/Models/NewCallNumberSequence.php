<?php namespace Junebug\Models;

use Log;

class NewCallNumberSequence extends CallNumberSequence {

  public function callNumber() {
    return $this->prefix . '-' . $this->collectionId . '/' . $this->next;
  }
  
}
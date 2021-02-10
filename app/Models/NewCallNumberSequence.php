<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewCallNumberSequence extends CallNumberSequence {
  use HasFactory;

  public function callNumber() {
    return $this->prefix . '-' . $this->archival_identifier . '/' . $this->next;
  }
  
}
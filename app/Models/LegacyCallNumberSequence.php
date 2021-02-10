<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegacyCallNumberSequence extends CallNumberSequence {
  use HasFactory;

  public function callNumber() {        
    return $this->prefix . '-' . $this->next;
  }

}
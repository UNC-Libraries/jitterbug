<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class AuditRecord extends Model {
	use CamelCaseModel;
	
  public function user()
  {
    return $this->belongsTo('Junebug\Models\User');
  }

  public function render() {
    return $this->userFullName() . " changed " . $this->attribute . " " . 
         " from '" . $this->oldValue . "' to '" . $this->newValue . "' on " . 
         $this->createdAt;
  }

  private function displayAttribute() {
    
  }

  private function displayValue($value) {

  }

  private function userFullName() {
  	return $this->user->firstName . " " . $this->user->lastName; 
  }
}

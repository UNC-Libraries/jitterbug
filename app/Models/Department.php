<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class Department extends Model {
	use CamelCaseModel;
    
    public function preservationMasters()
    {
        return $this->hasMany('Junebug\Models\PreservationMaster')->get();
    }
}
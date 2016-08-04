<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {
	use CamelCasing;
    
    public function preservationMasters()
    {
        return $this->hasMany('Junebug\Models\PreservationMaster')->get();
    }
}
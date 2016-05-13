<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class Format extends Model {
	use CamelCaseModel;
    
    public function audioVisualItems()
    {
        return $this->hasMany('Junebug\Models\AudioVisualItem');
    }
}
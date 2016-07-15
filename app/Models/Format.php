<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class Format extends Model {
	use CamelCaseModel;
    
    public function scopeWithFutureUse($query)
    {
        return $query->where('prefix', '<>', 'D')->
                       where('prefix', '<>', 'DDVD');
    }

    public function audioVisualItems()
    {
        return $this->hasMany('Junebug\Models\AudioVisualItem');
    }

    public function identifiableName()
    {
    	return $this->name;
    }
}
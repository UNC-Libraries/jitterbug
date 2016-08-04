<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;

class Format extends Model {
	use CamelCasing;
    
    // Filters out formats that will not be used for new items
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
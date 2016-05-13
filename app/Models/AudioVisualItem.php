<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class AudioVisualItem extends Model {
	use CamelCaseModel;

	public function collection()
	{
		return $this->belongsTo('Junebug\Models\Collection');
	}

	public function format()
	{
		return $this->belongsTo('Junebug\Models\Format');
	}

	public function getTypeAttribute()
	{
		return rtrim($this->getAttribute("itemableType"),"Item");
	}

}

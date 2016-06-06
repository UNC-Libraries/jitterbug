<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class Transfer extends Model {
	use CamelCaseModel;
	use NullFieldPreserver;
}

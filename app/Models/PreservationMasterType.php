<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Simple model for displaying type filters in the Preservation Masters
 * section of the application. The underlying database object is a view.
 */
class PreservationMasterType extends Model {
	use CamelCasing;

}
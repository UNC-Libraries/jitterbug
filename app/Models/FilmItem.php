<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class FilmItem extends Model {
	use CamelCaseModel;
	use NullFieldPreserver;
    use RevisionableTrait;

    protected $revisionCreationsEnabled = true;
}


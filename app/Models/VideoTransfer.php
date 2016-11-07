<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class VideoTransfer extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'time_base_corrector' => 'isEmpty:nothing|%s',
    'ad_converter' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'time_base_corrector' => 'time base corrector',
    'ad_converter' => 'A/D converter',
  );

  protected $fillable = array('timeBaseCorrector', 
    'adConverter');

}
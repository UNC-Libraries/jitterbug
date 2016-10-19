<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class AudioTransfer extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'stylus' => 'isEmpty:nothing|%s',
    'cartridge' => 'isEmpty:nothing|%s',
    'first_sound' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'first_sound' => 'first sound',
  );

  protected $fillable = array('stylus',
    'cartridge', 'firstSound');

}
<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioTransfer extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;
  use HasFactory;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  public function superclass()
  {
    return $this->morphOne('Transfer', 'subclass')->withTrashed();
  }

  protected $revisionFormattedFields = array(
    'stylus' => 'isEmpty:nothing|%s',
    'cartridge' => 'isEmpty:nothing|%s',
    'first_sound' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'first_sound' => 'first sound',
  );

  protected $fillable = array('stylus',
    'cartridge', 'first_sound');

}
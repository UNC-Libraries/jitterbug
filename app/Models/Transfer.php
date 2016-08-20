<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class Transfer extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  public function engineer()
  {
    return $this->belongsTo('Junebug\Models\User', 'engineer_id');
  }

  public function getEngineerNameAttribute()
  {
    $name = null;
    if ($this->engineer !== null) {
      $firstName = $this->engineer->firstName;
      $lastName = $this->engineer->lastName;
    } else {
      return null;
    }
    if ($firstName===null || $lastName===null) {
      $name = $this->engineer->legacyInitials;
    } else {
      $name = $firstName . ' ' . $lastName;
    }
    return $name;
  }

  public function playbackMachine()
  {
    return $this->belongsTo('Junebug\Models\PlaybackMachine');
  }

  public function transferable()
  {
    return $this->morphTo();
  }
}

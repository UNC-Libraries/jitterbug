<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioVisualItem extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use RevisionableTrait;

  protected $revisionCreationsEnabled = true;
  
  protected $guarded = ['id', 'itemable', 'itemableType', 'itemableId'];

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
    $fullType = $this->getAttribute("itemableType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Item"));
    return $type;
  }

  public function preservationMasters()
  {
    return $this->hasMany('Junebug\Models\PreservationMaster', 'call_number', 'call_number')->get();
  }

  public function itemable()
  {
    return $this->morphTo();
  }

}

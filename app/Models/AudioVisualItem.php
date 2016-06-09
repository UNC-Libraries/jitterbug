<?php namespace Junebug\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Database\Traits\CamelCaseModel;

class AudioVisualItem extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use Auditable;

  protected $guarded = ['id', 'itemable', 'itemableType', 'itemableId'];

  /*public static function boot()
  {
    parent::boot();
  }*/

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

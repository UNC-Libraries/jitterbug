<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class AudioVisualItem extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use CompositeHistory;
  use SoftDeletes;

  protected $dates = array('deleted_at');
  
  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'title' => 'isEmpty:nothing|%s',
    'collection_id' => 'isEmpty:nothing|%s',
    'format_id' => 'isEmpty:nothing|%s',
    'recording_location' => 'isEmpty:nothing|%s',
    'oclc' => 'isEmpty:nothing|%s',
    'item_year' => 'isEmpty:nothing|%s',
    'item_date' => 'isEmpty:nothing|%s',
    'speed' => 'isEmpty:nothing|%s',
    'entry_date' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'container_note' => 'container note',
    'call_number' => 'call number',
    'recording_location' => 'recording location',
    'item_year' => 'item year',
    'item_date' => 'item date',
    'entry_date' => 'entry date',
    'oclc' => 'OCLC Id',
  );

  protected $fillable = array('callNumber', 'title',
    'recordingLocation', 'itemYear', 'itemDate', 
    'collectionId', 'containerNote', 'conditionNote', 'oclc', 
    'formatId', 'entryDate', 'speed');

  public function __construct()
  {
    $this->itemableType = 'AudioItem';
    $this->entryDate = (new \DateTime())->format('Y-m-d');
    parent::__construct();
  }

  public function batch()
  {
    return false;
  }

  public function collection()
  {
    return $this->belongsTo('Junebug\Models\Collection');
  }

  public function format()
  {
    return $this->belongsTo('Junebug\Models\Format');
  }

  public function preservationMasters()
  {
    return $this->hasMany('Junebug\Models\PreservationMaster', 
      'call_number', 'call_number');
  }

  public function cuts()
  {
    return $this->hasMany('Junebug\Models\Cut', 
      'call_number', 'call_number');
  }

  public function itemable()
  {
    return $this->morphTo();
  }

  // Added to overcome an exception that was being thrown after the upgrade to
  // Laravel 5.1.40. With Laravel 5.0, no batch attribute was needed on this
  // model when displaying the creation form, which includes a batch (true or 
  // false) checkbox bound to this model.
  public function getBatchAttribute()
  {
    return $this->batch();
  }

  public function getTypeAttribute()
  {
    $fullType = $this->getAttribute("itemableType");
    $type = substr($fullType,0,strlen($fullType) - strlen("Item"));
    return $type;
  }

  public function getTypeIdAttribute()
  {
    // Rather than doing a query, we'll just return hardcoded values
    $type = $this->getAttribute("type");
    if($type==='Audio') {
      return 1;
    } else if ($type==='Film') {
      return 2;
    } else if ($type==='Video') {
      return 3;
    }
  }

}

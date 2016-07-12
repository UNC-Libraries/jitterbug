<?php namespace Junebug\Models;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Eloquence\Database\Traits\CamelCaseModel;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioVisualItem extends Model {
  use CamelCaseModel;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];
  
  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'title' => 'isEmpty:nothing|%s',
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

  protected $guarded = ['id', 'itemable', 'itemableType', 'itemableId'];

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
    if($type=='Audio') {
      return 1;
    } else if ($type=='Film') {
      return 2;
    } else if ($type=='Video') {
      return 3;
    }
  }

  public function preservationMasters()
  {
    return $this->hasMany('Junebug\Models\PreservationMaster', 
      'call_number', 'call_number')->get();
  }

  public function itemable()
  {
    return $this->morphTo();
  }

  public function completeRevisionHistory()
  {
    $itemRevisionHistory = $this->revisionHistory()->get();
    $itemableRevisionHistory = $this->itemable->revisionHistory()->get();
    $completeRevisionHistory = $itemRevisionHistory->
                               merge($itemableRevisionHistory);
    $completeRevisionHistory->sortBy('created_at');

    // Revisions that appear to be duplicate to the user are possible 
    // in the case of a call number update, which updates the call 
    // numbers on both AudioVisualItem and AudioItem (or FilmItem,
    // VideoItem), so remove the duplicates. Yes, this is a hack to
    // get around the fact that call numbers shouldn't be on the
    // itemable tables. But for the purposes of data migration they
    // are needed for now.
    $compositeKeys = array();
    foreach ($completeRevisionHistory as $key => $history) {
      $compositeKey = $history->transaction_id.$history->field.
                      $history->old_value.$history->new_value;
      if(in_array($compositeKey,$compositeKeys)) {
        $completeRevisionHistory->pull($key);
      } else {
        array_push($compositeKeys,$compositeKey);
      }
    }

    return $completeRevisionHistory;
  }

}

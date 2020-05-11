<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class Transfer extends Model {
  use NullFieldPreserver;
  use RevisionableTrait;
  use CompositeHistory;
  use SoftDeletes;
  use Markable;

  const BATCH_EDIT_MAX_LIMIT = 1000;
  const BATCH_IMPORT_KEY =  'OriginalPm';
  const AUDIO_IMPORT_KEYS = [
    'CallNumber', 'OriginatorReference', 'Side',
    'PlaybackMachine', 'FileSize', 'Duration',
    'OriginationDate', 'TransferNote', 'IART',
    'OriginalPm', 'Size', 'TrackConfiguration',
    'Base', 'Speed'
  ];
  const VIDEO_IMPORT_KEYS = [
    'CallNumber', 'FileName', 'Codec', 'Duration',
    'FileSize', 'PreservationChecksum', 'AspectRatio', 'TransferMachine',
    'TimeBaseCorrector', 'A/Dconverter', 'CaptureEngineer', 'IART',
    'Date', 'Color', 'Sound', 'Format'
  ];

  protected $dates = ['deleted_at'];

  protected $revisionCreationsEnabled = true;

  protected $revisionFormattedFields = array(
    'transfer_date' => 'isEmpty:nothing|%s',
    'playback_machine_id' => 'isEmpty:nothing|%s',
    'engineer_id' => 'isEmpty:nothing|%s',
    'vendor_id' => 'isEmpty:nothing|%s',
    'condition_note' => 'isEmpty:nothing|%s',
    'transfer_note' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'preservation_master_id' => 'preservation master',
    'transfer_date' => 'transfer date',
    'transfer_note' => 'transfer note',
    'condition_note' => 'condition note',
    'playback_machine_id' => 'playback machine',
    'vendor_id' => 'vendor',
    'enginer_id' => 'engineer',
  );

  protected $fillable = array('call_number',
    'preservation_master_id', 'transfer_date',
    'playback_machine_id', 'engineer_id', 'vendor_id',
    'condition_note', 'transfer_note');

  public function __construct($attributes = [])
  {
    $this->subclass_type = 'AudioTransfer';
    $this->transfer_date = (new \DateTime())->format('Y-m-d');
    parent::__construct($attributes);
  }

  public function item()
  {
    return $this->belongsTo('Jitterbug\Models\AudioVisualItem', 'call_number', 'call_number');
  }
  
  /**
   * Return the associated cut, if there is one.
   */
  public function cut()
  {
    return $this->hasOne('Jitterbug\Models\Cut');
  }

  public function engineer()
  {
    return $this->belongsTo('Jitterbug\Models\User', 'engineer_id');
  }

  public function getEngineerNameAttribute()
  {
    $name = null;
    if ($this->engineer !== null) {
      $firstName = $this->engineer->first_name;
      $lastName = $this->engineer->last_name;
    } else {
      return null;
    }
    if ($firstName===null || $lastName===null) {
      $name = $this->engineer->legacy_initials;
    } else {
      $name = $firstName . ' ' . $lastName;
    }
    return $name;
  }

  public function playbackMachine()
  {
    return $this->belongsTo('Jitterbug\Models\PlaybackMachine');
  }

  public function preservationMaster()
  {
    return $this->belongsTo('Jitterbug\Models\PreservationMaster');
  }

  public function vendor()
  {
    return $this->belongsTo('Jitterbug\Models\Vendor');
  }

  public function subclass()
  {
    return $this->morphTo();
  }

  public function batch()
  {
    return false;
  }

  public function getTypeAttribute()
  {
    $fullType = $this->getAttribute("subclass_type");
    $type = substr($fullType,0,strlen($fullType)
      - strlen("Transfer"));
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

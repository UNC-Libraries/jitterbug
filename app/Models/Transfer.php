<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class Transfer extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use CompositeHistory;
  use SoftDeletes;
  use Markable;

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

  protected $fillable = array('callNumber',
    'preservationMasterId', 'transferDate',
    'playbackMachineId', 'engineerId', 'vendorId',
    'conditionNote', 'transferNote');

  public function __construct()
  {
    $this->subclassType = 'AudioTransfer';
    $this->transferDate = (new \DateTime())->format('Y-m-d');
    parent::__construct();
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
    $fullType = $this->getAttribute("subclassType");
    $type = substr($fullType,0,strlen($fullType)
      - strlen("Transfer"));
    return $type;
  }

}

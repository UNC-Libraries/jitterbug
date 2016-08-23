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
    'transfer_date' => 'transfer date',
    'condition_note' => 'condition note',
    'transfer_note' => 'transfer note',
  );

  /**
   * Return the associated cut, if there is one.
   */
  public function cut()
  {
    return $this->hasOne('Junebug\Models\Cut');
  }

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

  public function preservationMaster()
  {
    return $this->belongsTo('Junebug\Models\PreservationMaster');
  }

  public function transferable()
  {
    return $this->morphTo();
  }

  public function getTypeAttribute()
  {
    $fullType = $this->getAttribute("masterableType");
    $type = substr($fullType,0,strlen($fullType)
      - strlen("Transfer"));
    return $type;
  }

  /**
   * Merges the revision histories of the transfer and the
   * associated audio/film/video transfer since they should appear as one
   * to the end user.
   * 
   * @return Collection
   */
  public function completeRevisionHistory()
  {
    $transferRevisionHistory = $this->revisionHistory()->get();
    $transferableRevisionHistory = 
                                $this->transferable->revisionHistory()->get();
    $completeRevisionHistory = $transferRevisionHistory->
                               merge($transferableRevisionHistory);
    $completeRevisionHistory = $completeRevisionHistory->sortBy('created_at');

    // Remove any revisions that will appear to be duplicate to the 
    // user. This is currently only an issue with AudioVisualItems, but we
    // will do it here for future protection.
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

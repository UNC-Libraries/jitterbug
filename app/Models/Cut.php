<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Venturecraft\Revisionable\RevisionableTrait;

class Cut extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use RevisionableTrait;
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $revisionFormattedFields = array(
    'side' => 'isEmpty:nothing|%s',
    'cut_number' => 'isEmpty:nothing|%s',
    'title' => 'isEmpty:nothing|%s',
    'performer_composer' => 'isEmpty:nothing|%s',
    'pm_start_time' => 'isEmpty:nothing|%s',
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'preservation_master_id' => 'preservation master',
    'cut_number' => 'cut number',
    'performer_composer' => 'performer composer',
    'pm_start_time' => 'PM start time',
  );

  protected $fillable = array('callNumber',
    'preservationMasterId', 'transferId', 'side', 'cutNumber',
    'side', 'title', 'performerComposer', 'pmStartTime');

  protected $revisionCreationsEnabled = true;

  public function item()
  {
    return $this->belongsTo('Jitterbug\Models\AudioVisualItem', 'call_number', 'call_number');
  }
  
  public function preservationMaster()
  {
    return $this->belongsTo('Jitterbug\Models\PreservationMaster');
  }

  public function transfer()
  {
    return $this->belongsTo('Jitterbug\Models\Transfer');
  }

  /**
   * Returns the revision history for the Cut.
   * 
   * @return Collection
   */
  public function completeRevisionHistory()
  {
    return $this->revisionHistory()->get();
  }

  public function getCreatedOnDisplayAttribute()
  {
    $revisionHistory = $this->completeRevisionHistory();
    return $this->formattedHistory($revisionHistory->first());
  }

  public function getUpdatedOnDisplayAttribute()
  {
    $revisionHistory = $this->completeRevisionHistory();
    $revisionHistory = $revisionHistory->sortByDesc('created_at');
    return $this->formattedHistory($revisionHistory->first());
  }

  public function formattedHistory($history)
  {
    $user = $history->userResponsible()->firstName 
      . ' ' . $history->userResponsible()->lastName;
    $date =  date('n/j/Y', strtotime($history->created_at));
    return $date . ' by ' . $user;
  }
}

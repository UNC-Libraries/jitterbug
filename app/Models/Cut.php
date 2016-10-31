<?php namespace Junebug\Models;

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
  );

  protected $revisionFormattedFieldNames = array(
    'call_number' => 'call number',
    'preservation_master_id' => 'preservation master',
    'cut_number' => 'cut number',
    'performer_composer' => 'performer composer',
  );

  protected $fillable = array('callNumber',
    'preservationMasterId', 'side', 'cutNumber',
    'side', 'title', 'performerComposer');

  protected $revisionCreationsEnabled = true;

  public function preservationMaster()
  {
    return $this->belongsTo('Junebug\Models\PreservationMaster');
  }

  public function transfer()
  {
    return $this->belongsTo('Junebug\Models\Transfer');
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

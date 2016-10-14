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

  protected $revisionCreationsEnabled = true;

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

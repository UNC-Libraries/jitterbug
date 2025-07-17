<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Cut extends Model
{
    use HasFactory;
    use NullFieldPreserver;
    use RevisionableTrait;
    use SoftDeletes;

    protected $revisionFormattedFields = [
        'side' => 'isEmpty:nothing|%s',
        'cut_number' => 'isEmpty:nothing|%s',
        'title' => 'isEmpty:nothing|%s',
        'performer_composer' => 'isEmpty:nothing|%s',
        'pm_start_time' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'call_number' => 'call number',
        'preservation_instance_id' => 'preservation instance',
        'cut_number' => 'cut number',
        'performer_composer' => 'performer composer',
        'pm_start_time' => 'PM start time',
    ];

    protected $fillable = ['call_number',
        'preservation_instance_id', 'transfer_id', 'side', 'cut_number',
        'side', 'title', 'performer_composer', 'pm_start_time', ];

    protected $revisionCreationsEnabled = true;

    public function item(): BelongsTo
    {
        return $this->belongsTo(\Jitterbug\Models\AudioVisualItem::class, 'call_number', 'call_number');
    }

    public function preservationInstance(): BelongsTo
    {
        return $this->belongsTo(\Jitterbug\Models\PreservationInstance::class);
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(\Jitterbug\Models\Transfer::class);
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
        $user = $history->userResponsible()->first_name
      .' '.$history->userResponsible()->last_name;
        $date = date('n/j/Y', strtotime($history->created_at));

        return $date.' by '.$user;
    }
}

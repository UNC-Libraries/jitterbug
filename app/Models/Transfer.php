<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Transfer extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use CompositeHistory;
    use SoftDeletes;
    use Markable;
    use HasFactory;

    const BATCH_EDIT_MAX_LIMIT = 1000;

    const BATCH_IMPORT_KEY = 'OriginalPm';

    const AUDIO_IMPORT_KEYS = [
        'CallNumber', 'OriginatorReference', 'Side',
        'PlaybackMachine', 'FileSize', 'Duration',
        'OriginationDate', 'TransferNote', 'IART',
        'OriginalPm', 'Size', 'TrackConfiguration',
        'Base', 'Speed',
    ];

    const VIDEO_IMPORT_KEYS = [
        'CallNumber', 'FileName', 'Codec', 'Duration',
        'FileSize', 'PreservationChecksum', 'AspectRatio', 'TransferMachine',
        'TimeBaseCorrector', 'A/Dconverter', 'CaptureEngineer', 'IART',
        'Date', 'Color', 'Sound', 'Format',
    ];
    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'transfer_date' => 'isEmpty:nothing|%s',
        'playback_machine_id' => 'isEmpty:nothing|%s',
        'engineer_id' => 'isEmpty:nothing|%s',
        'vendor_id' => 'isEmpty:nothing|%s',
        'condition_note' => 'isEmpty:nothing|%s',
        'transfer_note' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'call_number' => 'call number',
        'preservation_instance_id' => 'preservation instance',
        'transfer_date' => 'transfer date',
        'transfer_note' => 'transfer note',
        'condition_note' => 'condition note',
        'playback_machine_id' => 'playback machine',
        'vendor_id' => 'vendor',
        'enginer_id' => 'engineer',
    ];

    protected $fillable = ['call_number',
        'preservation_instance_id', 'transfer_date',
        'playback_machine_id', 'engineer_id', 'vendor_id',
        'condition_note', 'transfer_note', ];

    public function __construct($attributes = [])
    {
        $this->subclass_type = 'AudioTransfer';
        $this->transfer_date = (new \DateTime())->format('Y-m-d');
        parent::__construct($attributes);
    }

    public function item()
    {
        return $this->belongsTo(\Jitterbug\Models\AudioVisualItem::class, 'call_number', 'call_number');
    }

    /**
     * Return the associated cut, if there is one.
     */
    public function cut()
    {
        return $this->hasOne(\Jitterbug\Models\Cut::class);
    }

    public function engineer()
    {
        return $this->belongsTo(\Jitterbug\Models\User::class, 'engineer_id');
    }

    public function getEngineerNameAttribute()
    {
        $engineer = $this->engineer;
        // video transfers are done by a vendor so there is no related engineer
        if ($engineer === null) {
            return null;
        }

        return $engineer->fullName();
    }

    public function playbackMachine()
    {
        return $this->belongsTo(\Jitterbug\Models\PlaybackMachine::class);
    }

    public function preservationInstance()
    {
        return $this->belongsTo(\Jitterbug\Models\PreservationInstance::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\Jitterbug\Models\Vendor::class);
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
        $fullType = $this->getAttribute('subclass_type');
        $type = substr($fullType, 0, strlen($fullType)
      - strlen('Transfer'));

        return $type;
    }

    public function getTypeIdAttribute()
    {
        // Rather than doing a query, we'll just return hardcoded values
        $type = $this->getAttribute('type');
        if ($type === 'Audio') {
            return 1;
        } elseif ($type === 'Film') {
            return 2;
        } elseif ($type === 'Video') {
            return 3;
        }
    }
}

<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class AudioVisualItem extends Model
{
    use NullFieldPreserver;
    use RevisionableTrait;
    use CompositeHistory;
    use SoftDeletes;
    use Markable;
    use HasFactory;

    const BATCH_EDIT_MAX_LIMIT = 1000;

    const IMPORT_KEYS = [
        'Type', 'Title', 'ArchivalIdentifier', 'ContainerNote',
        'AccessionNumber', 'LegacyID', 'FormatID', 'RecLocation',
        'ItemYear', 'ItemDate', 'Size', 'Element',
        'Base', 'Color', 'SoundType', 'LengthInFeet',
        'ContentDescription', 'ReelTapeNumber', 'CallNumber', 'AccessRestrictions',
    ];

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFields = [
        'title' => 'isEmpty:nothing|%s',
        'container_note' => 'isEmpty:nothing|%s',
        'condition_note' => 'isEmpty:nothing|%s',
        'collection_id' => 'isEmpty:nothing|%s',
        'accession_number' => 'isEmpty:nothing|%s',
        'legacy' => 'isEmpty:nothing|%s',
        'format_id' => 'isEmpty:nothing|%s',
        'reel_tape_number' => 'isEmpty:nothing|%s',
        'recording_location' => 'isEmpty:nothing|%s',
        'physical_location' => 'isEmpty:nothing|%s',
        'access_restrictions' => 'isEmpty:nothing|%s',
        'oclc' => 'isEmpty:nothing|%s',
        'item_year' => 'isEmpty:nothing|%s',
        'item_date' => 'isEmpty:nothing|%s',
        'speed' => 'isEmpty:nothing|%s',
        'entry_date' => 'isEmpty:nothing|%s',
    ];

    protected $revisionFormattedFieldNames = [
        'container_note' => 'container note',
        'call_number' => 'call number',
        'reel_tape_number' => 'reel/tape number',
        'recording_location' => 'recording location',
        'physical_location' => 'physical location',
        'access_restrictions' => 'access restrictions',
        'accession_number' => 'accession number',
        'legacy' => 'legacy id',
        'item_year' => 'item year',
        'item_date' => 'item date',
        'entry_date' => 'entry date',
        'oclc' => 'OCLC Id',
    ];

    protected $fillable = ['call_number', 'title',
        'recording_location', 'physical_location', 'access_restrictions',
        'item_year', 'item_date', 'collection_id', 'accession_number',
        'legacy', 'format_id', 'reel_tape_number', 'container_note',
        'condition_note', 'oclc', 'entry_date', 'speed', 'blank', ];

    public function __construct($attributes = [])
    {
        $this->subclass_type = 'AudioItem';
        $this->entry_date = (new \DateTime())->format('Y-m-d');
        parent::__construct($attributes);
    }

    public function batch()
    {
        return false;
    }

    public function collection()
    {
        return $this->belongsTo(\Jitterbug\Models\Collection::class);
    }

    public function format()
    {
        return $this->belongsTo(\Jitterbug\Models\Format::class);
    }

    public function preservationInstances()
    {
        return $this->hasMany(\Jitterbug\Models\PreservationInstance::class,
            'call_number', 'call_number');
    }

    public function cuts()
    {
        return $this->hasMany(\Jitterbug\Models\Cut::class,
            'call_number', 'call_number');
    }

    public function subclass()
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
        $fullType = $this->subclass_type;
        $type = substr($fullType, 0, strlen($fullType) - strlen('Item'));

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

    public function getBlankDisplayAttribute($value): string
    {
        // the param $value is required for revisionable revision history
        // it may be blank due to usage in AV items show page
        $blank = $value ?? $this->blank;

        return $blank ? 'Yes' : 'No';
    }
}

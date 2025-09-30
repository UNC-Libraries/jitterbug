<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Jitterbug\Util\DurationFormat;

class BatchPreservationInstance extends PreservationInstance
{
    use MergeableAttributes;

    protected $instances;

    protected $subclasses;

    protected PreservationInstance $aggregateInstance;

    protected mixed $aggregateSubclass;

    protected array $batchGuarded = ['id', 'subclass_type', 'subclass_id', 'created_at',
        'updated_at', ];

    protected $attributes;

    public function __construct($instances, $subclasses)
    {
        // IRemove parent__construct call as it seems to also be called when instantiating the
        // PreservationInstance class in the batch constructor, which the batch class inherits from
        // parent::__construct();

        $this->instances = $instances;
        $this->subclasses = $subclasses;

        $this->aggregateInstance = new PreservationInstance;
        $subclassType = $this->instances->first()->subclass_type;
        $this->aggregateInstance->subclass_type = $subclassType;
        $this->aggregateSubclass = new $subclassType;
        $this->mergeAttributes($instances, $this->aggregateInstance);
        $this->mergeAttributes($subclasses, $this->aggregateSubclass);

        $this->attributes = $this->aggregateInstance->attributes;
    }

    public function batch(): true
    {
        return true;
    }

    public function getDurationAttribute(): float|int|string|null
    {
        if ($this->duration_in_seconds === '<mixed>') {
            return $this->duration_in_seconds;
        } else {
            return DurationFormat::toDuration($this->duration_in_seconds);
        }
    }

    public function getIdsAttribute(): string
    {
        $ids = [];
        foreach ($this->instances as $instance) {
            $ids[] = $instance->id;
        }

        return implode(',', $ids);
    }

    public function getSubclassAttribute()
    {
        return $this->aggregateSubclass;
    }

    public function subclass(): MorphTo
    {
        return $this->aggregateSubclass;
    }

    public function getTypeAttribute(): string
    {
        $fullType = $this->instances->first()->getAttribute('subclass_type');
        $type = substr($fullType, 0, strlen($fullType) - strlen('Instance'));

        return $type;
    }

    public function count()
    {
        return $this->instances->count();
    }
}

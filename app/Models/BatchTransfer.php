<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class BatchTransfer extends Transfer
{
    use MergeableAttributes;

    protected $transfers;

    protected $subclasses;

    protected Transfer $aggregateTransfer;

    protected mixed $aggregateSubclass;

    protected array $batchGuarded = ['id', 'subclass_type', 'subclass_id', 'created_at',
        'updated_at', ];

    protected $attributes;

    public function __construct($transfers, $subclasses)
    {
        // Remove parent__construct call as it seems to also be called when instantiating
        // the Transfer class in the batch constructor, which the batch class inherits from
        // parent::__construct();

        $this->transfers = $transfers;
        $this->subclasses = $subclasses;

        $this->aggregateTransfer = new Transfer;
        $subclassType = $this->transfers->first()->subclass_type;
        $this->aggregateTransfer->subclass_type = $subclassType;
        $this->aggregateSubclass = new $subclassType;
        $this->mergeAttributes($transfers, $this->aggregateTransfer);
        $this->mergeAttributes($subclasses, $this->aggregateSubclass);

        $this->attributes = $this->aggregateTransfer->attributes;
    }

    public function batch(): true
    {
        return true;
    }

    public function getIdsAttribute(): string
    {
        $ids = [];
        foreach ($this->transfers as $transfer) {
            $ids[] = $transfer->id;
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
        $fullType = $this->transfers->first()->getAttribute('subclass_type');
        $type = substr($fullType, 0, strlen($fullType) - strlen('Transfer'));

        return $type;
    }

    public function count()
    {
        return $this->transfers->count();
    }
}

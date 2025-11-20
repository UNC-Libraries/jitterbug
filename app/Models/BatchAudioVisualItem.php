<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class BatchAudioVisualItem extends AudioVisualItem
{
    use MergeableAttributes;

    protected $items;

    protected $subclasses;

    protected AudioVisualItem $aggregateItem;

    protected mixed $aggregateSubclass;

    protected array $batchGuarded = ['id', 'subclass_type', 'subclass_id', 'created_at',
        'updated_at', ];

    protected $attributes;

    public function __construct($items, $subclasses)
    {
        // Remove parent__construct call as it seems to also be called when instantiating the
        // AudioVisualItem class in the batch constructor, which the batch class inherits from
        // parent::__construct();

        $this->items = $items;
        $this->subclasses = $subclasses;

        $this->aggregateItem = new AudioVisualItem;
        $this->aggregateItem->entry_date = null;
        $subclassType = $this->items->first()->subclass_type;
        $this->aggregateItem->subclass_type = $subclassType;
        $this->aggregateSubclass = new $subclassType;
        $this->mergeAttributes($items, $this->aggregateItem);
        $this->mergeAttributes($subclasses, $this->aggregateSubclass);

        $this->attributes = $this->aggregateItem->attributes;
    }

    public function batch(): true
    {
        return true;
    }

    public function getIdsAttribute(): string
    {
        $ids = [];
        foreach ($this->items as $item) {
            $ids[] = $item->id;
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
        $fullType = $this->items->first()->getAttribute('subclass_type');
        $type = substr($fullType, 0, strlen($fullType) - strlen('Item'));

        return $type;
    }

    public function count()
    {
        return $this->items->count();
    }
}

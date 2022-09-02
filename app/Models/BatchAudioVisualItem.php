<?php

namespace Jitterbug\Models;

class BatchAudioVisualItem extends AudioVisualItem
{
    use MergeableAttributes;

    protected $items;

    protected $subclasses;

    protected $aggregateItem;

    protected $aggregateSubclass;

    protected $batchGuarded = ['id', 'subclass_type', 'subclass_id', 'created_at',
        'updated_at', ];

    protected $attributes;

    public function __construct($items, $subclasses)
    {
        parent::__construct();

        $this->items = $items;
        $this->subclasses = $subclasses;

        $this->aggregateItem = new AudioVIsualItem;
        $this->aggregateItem->entry_date = null;
        $subclassType = $this->items->first()->subclass_type;
        $this->aggregateItem->subclass_type = $subclassType;
        $this->aggregateSubclass = new $subclassType;
        $this->mergeAttributes($items, $this->aggregateItem);
        $this->mergeAttributes($subclasses, $this->aggregateSubclass);

        $this->attributes = $this->aggregateItem->attributes;
    }

    public function batch()
    {
        return true;
    }

    public function getIdsAttribute()
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

    public function subclass()
    {
        return $this->aggregateSubclass;
    }

    public function getTypeAttribute()
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

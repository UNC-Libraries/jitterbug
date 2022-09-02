<?php

namespace Jitterbug\Presenters;

/**
 * Used for displaying object type counts in the overview section
 * of the dashboard.
 */
class TypeCounts
{
    /**
     * Collection of AudioVisualItemType, PreservationInstanceType,
     * or TransferType.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $types;

    /**
     * Create a new instance. Requires a collection of
     * AudioVisualItemType, PreservationInstanceType or
     * TransferType.
     *
     * @param  \Illuminate\Support\Collection  $types Collection of
     * AudioVisualItemType, PreservationInstanceType, or TransferType.
     */
    public function __construct($types)
    {
        $this->types = $types;
    }

    /**
     * Return counts of all media types as a comma delimited
     * string. Ordered by Audio, Film, Video.
     */
    public function counts()
    {
        return $this->count('Audio').','
         .$this->count('Film').','
         .$this->count('Video');
    }

    /**
     * Return a total count of all media types.
     */
    public function total()
    {
        return number_format($this->types->pluck('count')->sum());
    }

    /**
     * Return a count of all for a particular object type, audio, film,
     * or video.
     */
    private function count($countType)
    {
        foreach ($this->types as $type) {
            if ($type->name === $countType) {
                return $type->count;
            }
        }

        return 0;
    }
}

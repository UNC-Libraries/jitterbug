<?php

use Illuminate\Support\Facades\Facade;

return [

    'aliases' => Facade::defaultAliases()->merge([
        'AudioInstance' => Jitterbug\Models\AudioInstance::class,
        'AudioItem' => Jitterbug\Models\AudioItem::class,
        'AudioTransfer' => Jitterbug\Models\AudioTransfer::class,
        'AudioVisualItem' => Jitterbug\Models\AudioVisualItem::class,
        'Breadcrumbs' => Diglactic\Breadcrumbs\Breadcrumbs::class,
        'Cut' => Jitterbug\Models\Cut::class,
        'FilmInstance' => Jitterbug\Models\FilmInstance::class,
        'FilmItem' => Jitterbug\Models\FilmItem::class,
        'FilmTransfer' => Jitterbug\Models\FilmTransfer::class,
        'Input' => 'Illuminate\Support\Facades\Input',
        'Inspiring' => 'Illuminate\Foundation\Inspiring',
        'PreservationInstance' => Jitterbug\Models\PreservationInstance::class,
        'Redis' => 'Illuminate\Support\Facades\Redis',
        'Transfer' => Jitterbug\Models\Transfer::class,
        'Uuid' => 'Ramsey\Uuid\Uuid',
        'VideoInstance' => Jitterbug\Models\VideoInstance::class,
        'VideoItem' => Jitterbug\Models\VideoItem::class,
        'VideoTransfer' => Jitterbug\Models\VideoTransfer::class,
    ])->toArray(),

];

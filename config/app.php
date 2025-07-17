<?php

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Facade;

return [

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
     * Laravel Framework Service Providers...
     */
        'Laravel\Tinker\TinkerServiceProvider',

        /*
     * Application Service Providers...
     */
        Jitterbug\Providers\AppServiceProvider::class,
        Jitterbug\Providers\AuthServiceProvider::class,
        // 'Jitterbug\Providers\BroadcastServiceProvider',
        Jitterbug\Providers\EventServiceProvider::class,
        Jitterbug\Providers\RouteServiceProvider::class,

        /*
     * Third-party Service Providers
     */
        // Comes from diglactic/laravel-breadcrumbs (^7.0)
        Diglactic\Breadcrumbs\ServiceProvider::class,
        'Venturecraft\Revisionable\RevisionableServiceProvider',
    ])->toArray(),

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

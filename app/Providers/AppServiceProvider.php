<?php

namespace Jitterbug\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Jitterbug\Models\AudioInstance;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Cut;
use Jitterbug\Models\FilmInstance;
use Jitterbug\Models\FilmItem;
use Jitterbug\Models\FilmTransfer;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\VideoInstance;
use Jitterbug\Models\VideoItem;
use Jitterbug\Models\VideoTransfer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // For legacy support of Jitterbug, keep resource parameters plural
        Route::singularResourceParameters(false);

        // Make the controller and action names available to views
        app('view')->composer('*', function ($view) {
            $route = app('request')->route();
            if ($route) {
                $action = app('request')->route()->getAction();
                $controller = class_basename($action['controller']);
                [$controller, $action] = explode('@', $controller);
                // Remove controller from the end of the name
                $controller =
          substr($controller, 0, strlen($controller) - strlen('Controller'));
                $controller = Str::camel($controller);
                $view->with(compact('controller', 'action'));
            }
        });

        // Setup the morphMap for the different object types
        Relation::morphMap([
            'AudioVisualItem' => AudioVisualItem::class,
            'AudioItem' => AudioItem::class,
            'FilmItem' => FilmItem::class,
            'VideoItem' => VideoItem::class,

            'PreservationInstance' => PreservationInstance::class,
            'AudioInstance' => AudioInstance::class,
            'FilmInstance' => FilmInstance::class,
            'VideoInstance' => VideoInstance::class,
            'Cut' => Cut::class,

            'Transfer' => Transfer::class,
            'AudioTransfer' => AudioTransfer::class,
            'FilmTransfer' => FilmTransfer::class,
            'VideoTransfer' => VideoTransfer::class,
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once __DIR__.'/../Http/helpers.php';
    }
}

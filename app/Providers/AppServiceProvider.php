<?php namespace Jitterbug\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\FilmItem;
use Jitterbug\Models\VideoItem;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\AudioMaster;
use Jitterbug\Models\FilmMaster;
use Jitterbug\Models\VideoMaster;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\FilmTransfer;
use Jitterbug\Models\VideoTransfer;

class AppServiceProvider extends ServiceProvider {

 /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    // For legacy support of Jitterbug, keep resource parameters plural
    Route::singularResourceParameters(false);

    // Make the controller and action names available to views
    app('view')->composer('*', function ($view) {
      $route = app('request')->route();
      if ($route) {
        $action = app('request')->route()->getAction();
        Log::error($action);
        $controller = class_basename($action['controller']);
        list($controller, $action) = explode('@', $controller);
        // Remove controller from the end of the name
        $controller = 
          substr($controller,0,strlen($controller) - strlen('Controller'));
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

      'PreservationMaster' => PreservationMaster::class,
      'AudioMaster' => AudioMaster::class,
      'FilmMaster' => FilmMaster::class,
      'VideoMaster' => VideoMaster::class,
      'Cut' => Cut::class,

      'Transfer' => Transfer::class,
      'AudioTransfer' => AudioTransfer::class,
      'FilmTransfer' => FilmTransfer::class,
      'VideoTransfer' => VideoTransfer::class,
    ]);

  }

 /**
  * Register any application services.
  *
  * @return void
  */
  public function register()
  {
    require_once __DIR__ . '/../Http/helpers.php';
  }

}

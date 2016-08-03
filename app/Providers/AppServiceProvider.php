<?php namespace Junebug\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	  // Make the controller and action names available to views
      app('view')->composer('layouts.master', function ($view) {
        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);
        list($controller, $action) = explode('@', $controller);
        // Remove controller from the end of the name
        $controller = 
             substr($controller,0,strlen($controller) - strlen('Controller'));
        $controller = camel_case($controller);
        $view->with(compact('controller', 'action'));
      });
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

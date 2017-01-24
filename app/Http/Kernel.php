<?php namespace Jitterbug\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
	];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
	protected $middlewareGroups = [
		'web' => [
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\Jitterbug\Http\Middleware\EncryptCookies::class,
			\Jitterbug\Http\Middleware\VerifyCsrfToken::class,
		],

		'api' => [
			'throttle:60,1',
		],
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'admin' => \Jitterbug\Http\Middleware\Admin::class,
		'auth' => \Jitterbug\Http\Middleware\Authenticate::class,
		'auth.basic' => 
			\Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'guest' => \Jitterbug\Http\Middleware\RedirectIfAuthenticated::class,
		'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
	];

}

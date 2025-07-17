<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \Laravel\Tinker\TinkerServiceProvider::class,
        \Diglactic\Breadcrumbs\ServiceProvider::class,
        \Venturecraft\Revisionable\RevisionableServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: [
            'referrer',
        ]);

        $middleware->append(\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class);

        $middleware->web([
            \Jitterbug\Http\Middleware\EncryptCookies::class,
            \Jitterbug\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $middleware->throttleApi('60,1');

        $middleware->alias([
            'admin' => \Jitterbug\Http\Middleware\Admin::class,
            'auth' => \Jitterbug\Http\Middleware\Authenticate::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'guest' => \Jitterbug\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

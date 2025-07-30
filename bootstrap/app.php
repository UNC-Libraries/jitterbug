<?php

use Diglactic\Breadcrumbs\ServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Jitterbug\Http\Middleware\Admin;
use Jitterbug\Http\Middleware\Authenticate;
use Jitterbug\Http\Middleware\EncryptCookies;
use Jitterbug\Http\Middleware\RedirectIfAuthenticated;
use Jitterbug\Http\Middleware\VerifyCsrfToken;
use Laravel\Tinker\TinkerServiceProvider;
use Venturecraft\Revisionable\RevisionableServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        TinkerServiceProvider::class,
        ServiceProvider::class,
        RevisionableServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: [
            'referrer',
        ]);

        $middleware->append(CheckForMaintenanceMode::class);

        $middleware->web([
            EncryptCookies::class,
            VerifyCsrfToken::class
        ]);

        $middleware->throttleApi('60,1');

        $middleware->alias([
            'admin' => Admin::class,
            'auth' => Authenticate::class,
            'bindings' => SubstituteBindings::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

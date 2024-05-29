<?php

use Illuminate\Support\Facades\Facade;

return [
    'name' => 'Jitterbug',

    /*
  |--------------------------------------------------------------------------
  | Application Environment
  |--------------------------------------------------------------------------
  |
  | This value determines the "environment" your application is currently
  | running in. This may determine how you prefer to configure various
  | services your application utilizes. Set this in your ".env" file.
  |
  */

    'env' => env('APP_ENV', 'production'),

    /*
  |--------------------------------------------------------------------------
  | Application Debug Mode
  |--------------------------------------------------------------------------
  |
  | When your application is in debug mode, detailed error messages with
  | stack traces will be shown on every error that occurs within your
  | application. If disabled, a simple generic error page is shown.
  |
  */

    'debug' => env('APP_DEBUG'),

    /*
  |--------------------------------------------------------------------------
  | Application URL
  |--------------------------------------------------------------------------
  |
  | This URL is used by the console to properly generate URLs when using
  | the Artisan command line tool. You should set this to the root of
  | your application so that it is used when running Artisan tasks.
  |
  */

    'url' => 'http://localhost',

    /*
  |--------------------------------------------------------------------------
  | Application Timezone
  |--------------------------------------------------------------------------
  |
  | Here you may specify the default timezone for your application, which
  | will be used by the PHP date and date-time functions. We have gone
  | ahead and set this to a sensible default for you out of the box.
  |
  */

    'timezone' => 'UTC',

    /*
  |--------------------------------------------------------------------------
  | Application Locale Configuration
  |--------------------------------------------------------------------------
  |
  | The application locale determines the default locale that will be used
  | by the translation service provider. You are free to set this value
  | to any of the locales which will be supported by the application.
  |
  */

    'locale' => 'en',

    /*
  |--------------------------------------------------------------------------
  | Application Fallback Locale
  |--------------------------------------------------------------------------
  |
  | The fallback locale determines the locale to use when the current one
  | is not available. You may change the value to correspond to any of
  | the language folders that are provided through your application.
  |
  */

    'fallback_locale' => 'en',

    /*
  |--------------------------------------------------------------------------
  | Encryption Key
  |--------------------------------------------------------------------------
  |
  | This key is used by the Illuminate encrypter service and should be set
  | to a random, 32 character string, otherwise these encrypted strings
  | will not be safe. Please do this before deploying an application!
  |
  */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
  |--------------------------------------------------------------------------
  | Autoloaded Service Providers
  |--------------------------------------------------------------------------
  |
  | The service providers listed here will be automatically loaded on the
  | request to your application. Feel free to add your own services to
  | this array to grant expanded functionality to your applications.
  |
  */

    'providers' => [

        /*
     * Laravel Framework Service Providers...
     */
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Broadcasting\BroadcastServiceProvider',
        'Illuminate\Bus\BusServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider',
        'Illuminate\Notifications\NotificationServiceProvider',
        'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider',
        'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider',
        'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider',
        'Illuminate\View\ViewServiceProvider',
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
        Adldap\Laravel\AdldapServiceProvider::class,
        Adldap\Laravel\AdldapAuthServiceProvider::class,
        'Venturecraft\Revisionable\RevisionableServiceProvider',

    ],

    /*
  |--------------------------------------------------------------------------
  | Class Aliases
  |--------------------------------------------------------------------------
  |
  | This array of class aliases will be registered when this application
  | is started. However, feel free to register as many as you wish as
  | the aliases are "lazy" loaded so they don't hinder performance.
  |
  */

    'aliases' => Facade::defaultAliases()->merge([
        'Adldap' => 'Adldap\Laravel\Facades\Adldap',
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

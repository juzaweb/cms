<?php

namespace Juzaweb\CMS\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Juzaweb\Frontend\Http\Middleware\HandleInertiaRequests;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \Juzaweb\CMS\Http\Middleware\TrustHosts::class,
        \Juzaweb\CMS\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Juzaweb\CMS\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Juzaweb\CMS\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Juzaweb\CMS\Http\Middleware\GlobalMiddleware::class,
            \Juzaweb\CMS\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Juzaweb\CMS\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Juzaweb\CMS\Http\Middleware\XFrameHeadersMiddleware::class,
            //\Juzaweb\CMS\Http\Middleware\HandleInertiaRequests::class,
            \Juzaweb\Backend\Http\Middleware\Installed::class,
        ],

        'api' => [
            \Juzaweb\CMS\Http\Middleware\GlobalMiddleware::class,
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'admin' => [
            'web',
            \Juzaweb\CMS\Http\Middleware\Admin::class,
            \Juzaweb\Backend\Http\Middleware\HandleInertiaRequests::class,
        ],

        'theme' => [
            'web',
            HandleInertiaRequests::class,
            \Juzaweb\CMS\Http\Middleware\Theme::class,
        ],

        'master_admin' => [
            'web',
            \Juzaweb\Network\Http\Middleware\MasterAdmin::class
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \Juzaweb\CMS\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Juzaweb\CMS\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'install' => \Juzaweb\Backend\Http\Middleware\CanInstall::class,
    ];
}

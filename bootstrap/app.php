<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Juzaweb\Modules\Core\Application;
use Juzaweb\Modules\Core\Http\Middleware\Authenticate;
use Juzaweb\Modules\Core\Http\Middleware\Captcha;
use Juzaweb\Modules\Core\Http\Middleware\EnsureEmailIsVerified;
use Juzaweb\Modules\Core\Http\Middleware\ForceSchemeUrl;
use Juzaweb\Modules\Core\Http\Middleware\ValidateSignature;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(
        function (Middleware $middleware) {
            $middleware->alias([
                'auth' => Authenticate::class,
                'verified' => EnsureEmailIsVerified::class,
                'captcha' => Captcha::class,
                'signed' => ValidateSignature::class,
            ]);

            if (! env('VERIFY_TOKEN', true)) {
                $middleware->validateCsrfTokens(except: ['*']);
            }

            $middleware->append(ForceSchemeUrl::class);
        }
    )
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

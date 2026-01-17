<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Juzaweb\Modules\Core\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(
        function (Middleware $middleware) {
            $middleware->alias([
                'verified' => \Juzaweb\Modules\Core\Http\Middleware\EnsureEmailIsVerified::class,
                'captcha' => \Juzaweb\Modules\Core\Http\Middleware\Captcha::class,
                'signed' => \Juzaweb\Modules\Core\Http\Middleware\ValidateSignature::class,
            ]);

            if (! env('VERIFY_TOKEN', true)) {
                $middleware->validateCsrfTokens(except: ['*']);
            }

            $middleware->append(\Juzaweb\Modules\Core\Http\Middleware\ForceSchemeUrl::class);
        }
    )
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

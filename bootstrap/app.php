<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Juzaweb\Modules\Core\Application;
use Juzaweb\Modules\Core\Http\Middleware\Authenticate;
use Juzaweb\Modules\Core\Http\Middleware\Captcha;
use Juzaweb\Modules\Core\Http\Middleware\EnsureEmailIsVerified;
use Juzaweb\Modules\Core\Http\Middleware\ForceSchemeUrl;
use Juzaweb\Modules\Core\Http\Middleware\ValidateSignature;
use Laravel\Passport\Http\Middleware\CheckTokenForAnyScope;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(
        function (Middleware $middleware) {
            $middleware->redirectGuestsTo(
                fn (Request $request) => route('login', ['redirect' => $request->fullUrl()])
            );

            $middleware->alias([
                'auth' => Authenticate::class,
                'verified' => EnsureEmailIsVerified::class,
                'captcha' => Captcha::class,
                'signed' => ValidateSignature::class,
                'scope' => CheckTokenForAnyScope::class,
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

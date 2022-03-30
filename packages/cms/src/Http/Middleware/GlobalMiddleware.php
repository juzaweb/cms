<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Juzaweb\Facades\ActionRegister;

class GlobalMiddleware
{
    public function handle($request, Closure $next)
    {
        ActionRegister::init();

        do_action('juzaweb.init');

        return $next($request);
    }
}

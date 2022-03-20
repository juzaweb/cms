<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Juzaweb\Facades\ActionRegistion;

class GlobalMiddleware
{
    public function handle($request, Closure $next)
    {
        ActionRegistion::init();

        do_action('juzaweb.init');

        return $next($request);
    }
}

<?php

namespace App\Core\Http\Middleware;

use App\User;
use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (!\Auth::check()) {
            return abort(404);
        }
        
        if (!User::find(\Auth::id())->is_admin) {
            return abort(404);
        }
        
        return $next($request);
    }
}

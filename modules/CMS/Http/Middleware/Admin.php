<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login', [
                'redirect' => url()->current()
            ]);
        }

        if (!has_permission()) {
            return abort(403, 'You can not access this page.');
        }
        
        return $next($request);
    }
}

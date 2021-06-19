<?php

namespace Mymo\Backend\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Mymo\Core\Models\User;
use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
        
        if (!Auth::user()->is_admin) {
            return abort(404);
        }
        
        return $next($request);
    }
}

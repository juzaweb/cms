<?php

namespace Juzaweb\CMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Abstracts\Action;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route(
                'admin.login',
                [
                    'redirect' => url()->current()
                ]
            );
        }

        if (!has_permission()) {
            return abort(403, __('You can not access this page.'));
        }

        do_action(Action::BACKEND_INIT, $request);

        return $next($request);
    }
}

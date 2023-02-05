<?php

namespace Juzaweb\CMS\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Juzaweb\CMS\Abstracts\Action;

class Admin
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return RedirectResponse|mixed|never
     */
    public function handle($request, Closure $next): mixed
    {
        if (!Auth::check()) {
            return redirect()->route(
                'admin.login',
                [
                    'redirect' => url()->current(),
                ]
            );
        }
        
        if (!has_permission()) {
            abort(403, __('You can not access this page.'));
        }
        
        global $jw_user;
        
        if ($locale = $request->query('hl')) {
            $jw_user->update(['language' => $locale]);
        }
        
        if ($jw_user->language != get_config('language', 'en')) {
            Lang::setLocale($jw_user->language);
        }
        
        do_action(Action::BACKEND_INIT, $request);
        
        return $next($request);
    }
}

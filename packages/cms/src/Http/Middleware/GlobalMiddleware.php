<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Juzaweb\Facades\ActionRegistion;
use Juzaweb\Facades\Site;
use Juzaweb\Support\Installer;
use Juzaweb\Facades\Theme;

class GlobalMiddleware
{
    public function handle($request, Closure $next)
    {
        $site = Site::info();
        if (isset($site->error)) {
            return response($site->error, 403);
        }

        ActionRegistion::init();

        if (Installer::alreadyInstalled()) {
            $currentTheme = jw_current_theme();
            $themePath = Theme::getThemePath($currentTheme);

            if (is_dir($themePath)) {
                Theme::set($currentTheme);
            }
        }

        do_action('juzaweb.init');

        return $next($request);
    }
}

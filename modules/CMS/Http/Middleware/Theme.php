<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\ThemeLoader as ThemeFacade;
use Juzaweb\CMS\Support\Installer;

class Theme
{
    public function handle($request, Closure $next)
    {
        View::composer(
            '*',
            function ($view) use ($request) {
                global $jw_user;
                $user = $jw_user ? UserResource::make($jw_user)->toArray($request) : null;

                $view->with('user', $user);
                $view->with('is_admin', $user ? $user['is_admin'] : false);
                $view->with('auth', (bool) $user);
                $view->with('guest', !$user);
            }
        );

        if (Installer::alreadyInstalled()) {
            $currentTheme = jw_current_theme();
            $themePath = ThemeFacade::getThemePath($currentTheme);

            if (is_dir($themePath)) {
                ThemeFacade::set($currentTheme);
            }
        }

        do_action(Action::FRONTEND_INIT, $request);

        return $next($request);
    }
}

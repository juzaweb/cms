<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Juzaweb\CMS\Support\Installer;

class Installed
{
    public function handle($request, Closure $next)
    {
        if (! Installer::alreadyInstalled()) {
            if (!str_contains(Route::currentRouteName(), 'installer.')) {
                return redirect()->route('installer.welcome');
            }
        }

        return $next($request);
    }
}

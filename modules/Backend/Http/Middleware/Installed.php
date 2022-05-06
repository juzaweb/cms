<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzaweb/juzacms
 * @license    MIT
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
            if (strpos(Route::currentRouteName(), 'installer.') === false) {
                return redirect()->route('installer.welcome');
            }
        }

        return $next($request);
    }
}

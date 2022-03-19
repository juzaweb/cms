<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/12/2021
 * Time: 5:58 PM
 */

namespace Juzaweb\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Juzaweb\Support\Installer;

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

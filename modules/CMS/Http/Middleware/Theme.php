<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/12/2021
 * Time: 3:05 PM
 */

namespace Juzaweb\CMS\Http\Middleware;

use Closure;

class Theme
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}

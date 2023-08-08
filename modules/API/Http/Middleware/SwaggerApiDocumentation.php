<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Http\Middleware;

class SwaggerApiDocumentation
{
    public function handle($request, \Closure $next)
    {
        if (!config('juzaweb.api.enable')) {
            abort(404);
        }

        return $next($request);
    }
}

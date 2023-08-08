<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Abstracts\Action;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (!$user = Auth::guard('api')->user()) {
            abort(403, __('You can not access this page.'));
        }

        if (!has_permission($user)) {
            abort(403, __('You can not access this page.'));
        }

        do_action(Action::BACKEND_INIT, $request);

        return $next($request);
    }
}

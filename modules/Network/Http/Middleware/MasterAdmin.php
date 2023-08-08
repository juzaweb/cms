<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Abstracts\Action;

class MasterAdmin
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

        $user = Auth::user();

        if (! $user->isMasterAdmin()) {
            abort(404);
        }

        config()->set('juzaweb.plugin.enable_upload', true);
        config()->set('juzaweb.theme.enable_upload', true);

        do_action(Action::NETWORK_INIT, $request);

        return $next($request);
    }
}

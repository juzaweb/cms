<?php

namespace Mymo\Installer\Middleware;

use Closure;
use Mymo\Installer\Helpers\Intaller;

class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (Intaller::alreadyInstalled()) {
            $installedRedirect = config('installer.installedAlreadyAction');

            switch ($installedRedirect) {
                case 'route':
                    $routeName = config('installer.installed.redirectOptions.route.name');
                    $data = config('installer.installed.redirectOptions.route.message');

                    return redirect()->route($routeName)->with(['data' => $data]);
                    break;

                case 'abort':
                    abort(config('installer.installed.redirectOptions.abort.type'));
                    break;

                case 'dump':
                    $dump = config('installer.installed.redirectOptions.dump.data');
                    dd($dump);
                    break;

                case '404':
                case 'default':
                default:
                    abort(404);
                    break;
            }
        }

        return $next($request);
    }
}

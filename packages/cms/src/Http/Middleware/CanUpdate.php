<?php

namespace Juzaweb\Http\Middleware;

use Closure;
use Juzaweb\Traits\MigrationsHelper;

class CanUpdate
{
    use MigrationsHelper;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $updateEnabled = filter_var(config('installer.updaterEnabled'), FILTER_VALIDATE_BOOLEAN);
        switch ($updateEnabled) {
            case true:
                $canInstall = new CanInstall();

                // if the application has not been installed,
                // redirect to the installer
                if (! $canInstall->alreadyInstalled()) {
                    return redirect()->route('installer.welcome');
                }

                if ($this->alreadyUpdated()) {
                    abort(404);
                }

                break;

            case false:
            default:
                abort(404);

                break;
        }

        return $next($request);
    }

    /**
     * If application is already updated.
     *
     * @return bool
     */
    public function alreadyUpdated()
    {
        $migrations = $this->getMigrations();
        $dbMigrations = $this->getExecutedMigrations();

        // If the count of migrations and dbMigrations is equal,
        // then the update as already been updated.
        if (count($migrations) == count($dbMigrations)) {
            return true;
        }

        // Continue, the app needs an update
        return false;
    }
}

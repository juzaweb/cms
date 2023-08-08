<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Providers;

use Illuminate\Contracts\Console\Kernel;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Network\Commands\ArtisanCommand;
use Juzaweb\Network\Commands\MakeSiteCommand;
use Juzaweb\Network\Contracts\NetworkRegistionContract;
use Juzaweb\Network\Contracts\SiteCreaterContract;
use Juzaweb\Network\Contracts\SiteManagerContract;
use Juzaweb\Network\Contracts\SiteSetupContract;
use Juzaweb\Network\Facades\Network;
use Juzaweb\Network\Models\Site;
use Juzaweb\Network\NetworkAction;
use Juzaweb\Network\Observers\SiteModelObserver;
use Juzaweb\Network\Support\NetworkRegistion;
use Juzaweb\Network\Support\SiteCreater;
use Juzaweb\Network\Support\SiteManager;
use Juzaweb\Network\Support\SiteSetup;

class NetworkServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Network::init();

        $this->commands([MakeSiteCommand::class, ArtisanCommand::class]);

        Site::observe([SiteModelObserver::class]);

        ActionRegister::register(NetworkAction::class);
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'network');

        $this->app->singleton(
            SiteSetupContract::class,
            function ($app) {
                return new SiteSetup(
                    $app['config'],
                    $app['db']
                );
            }
        );

        $this->app->singleton(
            SiteCreaterContract::class,
            function ($app) {
                return new SiteCreater(
                    $app['db'],
                    $app['config'],
                    $app[SiteSetupContract::class]
                );
            }
        );

        $this->app->singleton(
            NetworkRegistionContract::class,
            function ($app) {
                return new NetworkRegistion(
                    $app,
                    $app['config'],
                    $app['request'],
                    $app['cache'],
                    $app['db'],
                    $app[SiteSetupContract::class],
                    $app[Kernel::class]
                );
            }
        );

        $this->app->singleton(
            SiteManagerContract::class,
            function ($app) {
                return new SiteManager(
                    $app['db'],
                    $app[SiteCreaterContract::class]
                );
            }
        );
    }
}

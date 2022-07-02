<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Network\Contracts\NetworkRegistionContract;
use Juzaweb\Network\Facades\Network;
use Juzaweb\Network\NetworkAction;
use Juzaweb\Network\Support\NetworkRegistion;

class NetworkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Network::init();

        ActionRegister::register(NetworkAction::class);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'network');

        $this->app->singleton(
            NetworkRegistionContract::class,
            function ($app) {
                return new NetworkRegistion(
                    $app,
                    $app['config'],
                    $app['request'],
                    $app['cache'],
                    $app['db']
                );
            }
        );
    }
}

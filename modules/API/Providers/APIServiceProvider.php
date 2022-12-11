<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\API\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Juzaweb\API\Actions\APIAction;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;

class APIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();
        
        ActionRegister::register(
            [
                APIAction::class,
            ]
        );
    }
    
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'api');
        
        $this->app->register(RouteServiceProvider::class);
    }
    
    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            'api',
            function (Request $request) {
                return Limit::perMinute(60)
                    ->by($request->user()?->id ?: get_client_ip());
            }
        );
    }
}

<?php

namespace Juzaweb\Subscription\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\Subscription\Contracts\SubscriptionContract;
use Juzaweb\Subscription\Manage\SubscriptionManage;
use Juzaweb\Subscription\SubscriptionAction;
use Juzaweb\CMS\Support\ServiceProvider;

class SubscriptionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'subr');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'subr');
    
        ActionRegister::register([
            SubscriptionAction::class
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(SubscriptionContract::class, function () {
            return new SubscriptionManage();
        });
    }
}

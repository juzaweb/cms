<?php

namespace Juzaweb\DemoSite\Providers;

use Juzaweb\DemoSite\DemoSiteAction;
use Juzaweb\Support\ServiceProvider;
use Juzaweb\Facades\ActionRegister;

class DemoSiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(DemoSiteAction::class);
        
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'demo'
        );
    }
}

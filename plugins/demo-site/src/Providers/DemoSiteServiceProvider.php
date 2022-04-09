<?php

namespace Juzaweb\DemoSite\Providers;

use Juzaweb\DemoSite\DemoSiteAction;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Facades\ActionRegister;

class DemoSiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(DemoSiteAction::class);
    }
}

<?php

namespace Juzaweb\DemoSite\Providers;

use Juzaweb\CMS\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'demo'
        );
    }
}

<?php

namespace Juzaweb\AdsManager\Providers;

use Juzaweb\AdsManager\AdsManagerAction;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;

class AdsManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(AdsManagerAction::class);
    }

    public function register()
    {
        //
    }
}

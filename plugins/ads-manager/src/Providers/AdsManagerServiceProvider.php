<?php

namespace Juzaweb\AdsManager\Providers;

use Juzaweb\AdsManager\AdsManagerAction;
use Juzaweb\Facades\ActionRegister;
use Juzaweb\Support\ServiceProvider;

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

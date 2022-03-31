<?php

namespace Juzaweb\ImageSlider\Providers;

use Juzaweb\Facades\ActionRegister;
use Juzaweb\Support\ServiceProvider;

class ImageSliderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(\Juzaweb\ImageSlider\ImageSliderAction::class);
    }
}

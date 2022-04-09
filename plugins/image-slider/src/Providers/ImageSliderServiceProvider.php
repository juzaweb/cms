<?php

namespace Juzaweb\ImageSlider\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;

class ImageSliderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(\Juzaweb\ImageSlider\ImageSliderAction::class);
    }
}

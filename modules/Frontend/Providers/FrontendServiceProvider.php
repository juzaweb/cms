<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Providers;

use Juzaweb\CMS\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
        //$this->app->register(RouteServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/theme.php', 'theme');
    }
}

<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Providers;

use Juzaweb\Ecommerce\EcommerceAction;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Facades\ActionRegister;

class EcommerceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(EcommerceAction::class);
        $basePath = __DIR__ . '/..';
        $this->loadViewsFrom($basePath . '/resources/views', 'ecom');
        $this->loadTranslationsFrom($basePath . '/resources/lang', 'ecom');
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

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
use Juzaweb\Support\ServiceProvider;

class EcommerceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $basePath = __DIR__ . '/..';
        $this->loadViewsFrom($basePath . '/resources/views', 'ecom');
        $this->loadTranslationsFrom($basePath . '/resources/lang', 'ecom');

        $this->registerAction([
            EcommerceAction::class
        ]);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

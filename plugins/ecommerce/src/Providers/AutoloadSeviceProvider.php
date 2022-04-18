<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Providers;

use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Ecommerce\Extensions\TwigExtension;
use Juzaweb\Ecommerce\Supports\CartInterface;
use Juzaweb\Ecommerce\Supports\OrderInterface;
use TwigBridge\Facade\Twig;

class AutoloadSeviceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $basePath = __DIR__ . '/..';
        $this->loadViewsFrom($basePath . '/resources/views', 'ecom');
        $this->loadTranslationsFrom($basePath . '/resources/lang', 'ecom');

        Twig::addExtension(new TwigExtension());
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/ecommerce.php',
            'ecommerce'
        );

        $this->publishes(
            [
                plugin_path('juzaweb/ecommerce', 'src/resources/assets/public')
                => base_path('public/jw-styles/plugins/ecommerce/assets')
            ],
            'ecom_assets'
        );

        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(
            CartInterface::class,
            config('ecommerce.cart')
        );

        $this->app->bind(
            OrderInterface::class,
            config('ecommerce.order')
        );
    }
}

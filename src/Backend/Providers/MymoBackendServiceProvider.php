<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/19/2021
 * Time: 6:31 PM
 */

namespace Mymo\Backend\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Backend\Http\Middleware\Admin;
use Illuminate\Routing\Router;
use Mymo\Backend\Macros\RouterMacros;
use Mymo\Core\Facades\HookAction;

class MymoBackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMiddlewares();
        $this->bootPublishes();
        HookAction::loadActionForm(__DIR__ . '/../actions');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mymo');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'mymo');
    }

    public function register()
    {
        $this->registerRouteMacros();
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../../../assets' => public_path('mymo'),
        ], 'mymo_assets');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('vendor/mymocms'),
        ], 'mymo_lang');
    }

    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}
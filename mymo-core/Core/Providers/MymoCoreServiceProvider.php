<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:53 PM
 */

namespace Mymo\Core\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
use Mymo\Security\Providers\MymoSecurityServiceProvider;
use Mymo\Theme\Providers\ThemeServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class MymoCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootMiddlewares();

        Validator::extend('recaptcha', 'Mymo\Core\Validators\Recaptcha@validate');
        Schema::defaultStringLength(150);
    }

    public function register()
    {
        $this->registerProviders();
    }

    protected function bootMigrations()
    {
        $mainPath = base_path('mymo-core/Core/database/migrations');
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }

    protected function registerProviders()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(MymoSecurityServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', \Mymo\Core\Http\Middleware\Admin::class);
    }
}
<?php
/**
 *
 *
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

use Illuminate\Support\Facades\Schema;
use Mymo\Backend\Providers\MymoBackendServiceProvider;
use Mymo\Backend\Providers\RouteServiceProvider;
use Mymo\Core\Helpers\HookAction;
use Mymo\Email\Providers\EmailTemplateServiceProvider;
use Mymo\FileManager\Providers\FilemanagerServiceProvider;
use Mymo\Notification\Providers\NotificationServiceProvider;
use Mymo\Performance\Providers\MymoPerformanceServiceProvider;
use Mymo\PostType\Providers\PostTypeServiceProvider;
use Mymo\Repository\Providers\RepositoryServiceProvider;
use Mymo\Theme\Providers\ThemeServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Mymo\Updater\UpdaterServiceProvider;
use Mymo\Installer\Providers\InstallerServiceProvider;

class MymoCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->loadFactoriesFrom(__DIR__ . '/../../../database/factories');

        Validator::extend('recaptcha', 'Mymo\Core\Validators\Recaptcha@validate');
        Schema::defaultStringLength(150);
    }

    public function register()
    {
        $this->registerProviders();
        $this->registerSingleton();
        $this->mergeConfigFrom(__DIR__ . '/../config/mymo.php', 'mymo');
    }

    protected function bootMigrations()
    {
        $mainPath = __DIR__ . '/../../../database/migrations';
        $this->loadMigrationsFrom($mainPath);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../config/mymo.php' => base_path('config/mymo.php'),
        ], 'mymo_config');
    }

    protected function registerProviders()
    {
        //$this->app->register(UpdaterServiceProvider::class);
        $this->app->register(MymoBackendServiceProvider::class);
        $this->app->register(InstallerServiceProvider::class);
        $this->app->register(DbConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(MymoPerformanceServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(FilemanagerServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(PostTypeServiceProvider::class);
        $this->app->register(NotificationServiceProvider::class);
        $this->app->register(EmailTemplateServiceProvider::class);
    }

    protected function registerSingleton()
    {
        $this->app->singleton('mymo.hook', function () {
            return new HookAction();
        });
    }
}
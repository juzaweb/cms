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
 * Date: 5/30/2021
 * Time: 1:16 PM
 */

namespace Mymo\PostType\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Core\Facades\HookAction;

class PostTypeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mymo_post_type');
        HookAction::loadActionForm(__DIR__ . '/../actions');
    }

    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    protected function bootMigrations()
    {
        $mainPath = __DIR__ . '/../database/migrations';
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }
}
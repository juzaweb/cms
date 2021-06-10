<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Time: 12:08 PM
 */

namespace Mymo\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package Mymo\Repository\Providers
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/repository.php', 'repository');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Mymo\Repository\Generators\Commands\RepositoryCommand');
        /*$this->commands('Mymo\Repository\Generators\Commands\TransformerCommand');
        $this->commands('Mymo\Repository\Generators\Commands\PresenterCommand');
        $this->commands('Mymo\Repository\Generators\Commands\EntityCommand');
        $this->commands('Mymo\Repository\Generators\Commands\ValidatorCommand');
        $this->commands('Mymo\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Mymo\Repository\Generators\Commands\BindingsCommand');
        $this->commands('Mymo\Repository\Generators\Commands\CriteriaCommand');*/
        $this->app->register('Mymo\Repository\Providers\EventServiceProvider');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

<?php
namespace Tadcms\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Tadcms\Repository\Providers
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
            __DIR__ . '/../../config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/repository.php', 'repository');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Tadcms\Repository\Generators\Commands\RepositoryCommand');
        /*$this->commands('Tadcms\Repository\Generators\Commands\TransformerCommand');
        $this->commands('Tadcms\Repository\Generators\Commands\PresenterCommand');
        $this->commands('Tadcms\Repository\Generators\Commands\EntityCommand');
        $this->commands('Tadcms\Repository\Generators\Commands\ValidatorCommand');
        $this->commands('Tadcms\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Tadcms\Repository\Generators\Commands\BindingsCommand');
        $this->commands('Tadcms\Repository\Generators\Commands\CriteriaCommand');*/
        $this->app->register('Tadcms\Repository\Providers\EventServiceProvider');
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

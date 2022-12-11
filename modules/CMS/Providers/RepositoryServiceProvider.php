<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package Prettus\Repository\Providers
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryServiceProvider extends ServiceProvider
{
    
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = false;
    
    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/../config/repository.php' => config_path('repository.php'),
            ]
        );
        
        $this->mergeConfigFrom(__DIR__.'/../config/repository.php', 'repository');
    }
    
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\RepositoryCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\TransformerCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\PresenterCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\EntityCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\ValidatorCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\ControllerCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\BindingsCommand');
        $this->commands('Juzaweb\CMS\Repositories\Generators\Commands\CriteriaCommand');
        $this->app->register('Juzaweb\CMS\Repositories\Providers\EventServiceProvider');
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

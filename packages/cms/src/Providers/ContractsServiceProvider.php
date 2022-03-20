<?php

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\RepositoryInterface;
use Juzaweb\Support\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, LaravelFileRepository::class);
    }
}

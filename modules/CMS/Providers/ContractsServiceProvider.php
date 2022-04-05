<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\CMS\Contracts\RepositoryInterface;
use Juzaweb\CMS\Support\LaravelFileRepository;

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

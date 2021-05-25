<?php

namespace Mymo\Module\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Module\Contracts\RepositoryInterface;
use Mymo\Module\Laravel\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}

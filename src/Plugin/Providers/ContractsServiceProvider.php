<?php

namespace Mymo\Plugin\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Plugin\Contracts\RepositoryInterface;
use Mymo\Plugin\Laravel\LaravelFileRepository;

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

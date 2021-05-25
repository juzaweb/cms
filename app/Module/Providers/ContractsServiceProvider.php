<?php

namespace App\Module\Providers;

use Illuminate\Support\ServiceProvider;
use App\Module\Contracts\RepositoryInterface;
use App\Module\Laravel\LaravelFileRepository;

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

<?php

namespace Tadcms\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Tadcms\Modules\Contracts\RepositoryInterface;
use Tadcms\Modules\Laravel\LaravelFileRepository;

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

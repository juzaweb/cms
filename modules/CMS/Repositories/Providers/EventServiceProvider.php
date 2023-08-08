<?php

namespace Juzaweb\CMS\Repositories\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package Prettus\Repository\Providers
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Juzaweb\CMS\Repositories\Events\RepositoryEntityCreated' => [
            'Juzaweb\CMS\Repositories\Listeners\CleanCacheRepository',
        ],
        'Juzaweb\CMS\Repositories\Events\RepositoryEntityUpdated' => [
            'Juzaweb\CMS\Repositories\Listeners\CleanCacheRepository',
        ],
        'Juzaweb\CMS\Repositories\Events\RepositoryEntityDeleted' => [
            'Juzaweb\CMS\Repositories\Listeners\CleanCacheRepository',
        ],
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}

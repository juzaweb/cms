<?php
namespace Tadcms\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EventServiceProvider
 * @package Tadcms\Repository\Providers
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
        'Tadcms\Repository\Events\RepositoryEntityCreated' => [
            'Tadcms\Repository\Listeners\CleanCacheRepository'
        ],
        'Tadcms\Repository\Events\RepositoryEntityUpdated' => [
            'Tadcms\Repository\Listeners\CleanCacheRepository'
        ],
        'Tadcms\Repository\Events\RepositoryEntityDeleted' => [
            'Tadcms\Repository\Listeners\CleanCacheRepository'
        ]
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

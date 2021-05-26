<?php
namespace Mymo\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EventServiceProvider
 * @package Mymo\Repository\Providers
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
        'Mymo\Repository\Events\RepositoryEntityCreated' => [
            'Mymo\Repository\Listeners\CleanCacheRepository'
        ],
        'Mymo\Repository\Events\RepositoryEntityUpdated' => [
            'Mymo\Repository\Listeners\CleanCacheRepository'
        ],
        'Mymo\Repository\Events\RepositoryEntityDeleted' => [
            'Mymo\Repository\Listeners\CleanCacheRepository'
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

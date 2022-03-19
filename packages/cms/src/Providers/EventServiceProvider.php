<?php

namespace Juzaweb\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Juzaweb\Events\EmailHook;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Listeners\CountViewPost;
use Juzaweb\Listeners\SendEmailHook;
use Juzaweb\Listeners\SendMailRegisterSuccessful;
use Juzaweb\Backend\Events\RegisterSuccessful;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EmailHook::class => [
            SendEmailHook::class,
        ],
        RegisterSuccessful::class => [
            SendMailRegisterSuccessful::class,
        ],
        PostViewed::class => [
            CountViewPost::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

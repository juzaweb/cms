<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\CMS\Events\EmailHook;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Listeners\CountViewPost;
use Juzaweb\CMS\Listeners\SendEmailHook;
use Juzaweb\Backend\Listeners\SendMailRegisterSuccessful;
use Juzaweb\Backend\Events\RegisterSuccessful;
use Juzaweb\Backend\Listeners\DumpAutoloadPluginListener;

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
        ],
        DumpAutoloadPlugin::class => [
            DumpAutoloadPluginListener::class,
        ],
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

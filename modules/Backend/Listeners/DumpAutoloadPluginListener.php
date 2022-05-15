<?php

namespace Juzaweb\Backend\Listeners;

use Illuminate\Support\Facades\Artisan;

class DumpAutoloadPluginListener
{
    /**
     * Handle the event.
     *
     * @param  mixed  $event
     * @return void
     */
    public function handle($event): void
    {
        Artisan::call('juzacms:plugin-autoload');
    }
}

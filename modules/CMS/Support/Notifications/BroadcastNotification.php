<?php

namespace Juzaweb\CMS\Support\Notifications;

use Juzaweb\CMS\Events\PusherEvent;

class BroadcastNotification extends NotificationAbstract
{
    public function handle()
    {
        event(new PusherEvent($user, $notification));
    }
}

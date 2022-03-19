<?php

namespace Juzaweb\Notification\Notifications;

use Juzaweb\Notification\Events\PusherEvent;

class BroadcastNotification extends NotificationAbstract
{
    public function handle()
    {
        event(new PusherEvent($user, $notification));
    }
}

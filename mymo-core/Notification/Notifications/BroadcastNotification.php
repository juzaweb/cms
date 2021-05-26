<?php

namespace Tadcms\Notification\Notifications;

use Tadcms\Notification\Events\PusherEvent;

class BroadcastNotification extends NotificationAbstract
{
    public function handle()
    {
        event(new PusherEvent($user, $notification));
    }
}

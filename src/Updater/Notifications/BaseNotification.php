<?php

declare(strict_types=1);

namespace Mymo\Updater\Notifications;

use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification
{
    public function via(): array
    {
        $notificationChannels = config('updater.notifications.notifications.'.static::class);

        return array_filter($notificationChannels);
    }
}

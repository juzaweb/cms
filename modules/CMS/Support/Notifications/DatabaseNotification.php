<?php

namespace Juzaweb\CMS\Support\Notifications;

use Illuminate\Support\Arr;
use Juzaweb\CMS\Models\User;
use Illuminate\Support\Facades\Notification;

class DatabaseNotification extends NotificationAbstract
{
    public function handle()
    {
        $query = User::query();
        $users = $this->users[0] != -1 ? $this->users : null;
        if ($users) {
            $query->whereIn('id', $users);
        }

        $users = $query->get();

        Notification::send(
            $users,
            new DbNotify(
                [
                    'subject' => Arr::get($this->notification->data, 'subject'),
                    'body' => Arr::get($this->notification->data, 'body'),
                    'url' => Arr::get($this->notification->data, 'url'),
                    'image' => Arr::get($this->notification->data, 'image'),
                ]
            )
        );
    }
}

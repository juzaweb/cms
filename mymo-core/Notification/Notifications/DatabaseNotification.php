<?php

namespace Tadcms\Notification\Notifications;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tadcms\Notification\Models\Notification;

class DatabaseNotification extends NotificationAbstract
{
    public function handle()
    {
        foreach ($this->users as $user) {
            Notification::create([
                'id' => (string) Str::uuid(),
                'type' => 'Tadcms\Notification\Notifications\DbNotify',
                'data' => [
                    'subject' => Arr::get($this->notification->data, 'subject'),
                    'body' => Arr::get($this->notification->data, 'body'),
                    'url' => Arr::get($this->notification->data, 'url'),
                    'image' => Arr::get($this->notification->data, 'image'),
                ],
                'notifiable_type' => 'App\User',
                'notifiable_id' => $user
            ]);
        }
    }
}

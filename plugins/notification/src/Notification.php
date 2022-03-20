<?php

namespace Juzaweb\Notification;

use Juzaweb\Notification\Jobs\SendNotification as SendNotificationJob;
use Juzaweb\Notification\Models\ManualNotification;

class Notification
{
    protected $subject;
    protected $users;
    protected $body;
    protected $url;
    protected $image;

    public static function register($key, $class, $priority = 20)
    {
        return add_filters('notify_methods', function ($items) use ($key, $class) {
            $items[$key] = [
                'class' => $class
            ];

            return $items;
        }, $priority);
    }

    public static function make()
    {
        return (new Notification());
    }

    /**
     * @param array|int|\Juzaweb\Models\User $users
     * @return $this
     * */
    public function setUsers($users)
    {
        $userIds = [];
        if (is_numeric($users)) {
            $userIds[] = $users;
        } elseif (is_array($users)) {
            foreach ($users as $user) {
                if (is_numeric($user)) {
                    $userIds[] = $user;
                } elseif (is_a($user, 'Illuminate\Foundation\Auth\User')) {
                    $userIds[] = $user->id;
                }
            }
        }

        $this->users = $userIds;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function send()
    {
        $notification = ManualNotification::create([
            'users' => implode(',', $this->users),
            'data' => [
                'subject' => $this->subject,
                'body' => $this->body,
                'url' => $this->url,
                'image' => $this->image,
            ],
        ]);

        switch (config('mymo.notification.method')) {
            case 'sync':
                (new SendNotification($notification))->send();
                break;
            case 'queue':
                SendNotificationJob::dispatch($notification);
                break;
        }
    }
}

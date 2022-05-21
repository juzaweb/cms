<?php

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Jobs\SendNotification as SendNotificationJob;
use Juzaweb\Backend\Models\ManualNotification;
use Illuminate\Foundation\Auth\User;

class Notification
{
    protected string $subject;
    protected $users;
    protected ?string $body = null;
    protected ?string $url = null;
    protected ?string $image = null;
    protected array $method = ['database'];

    public static function register($key, $class, $priority = 20)
    {
        return add_filters(
            'notify_methods',
            function ($items) use ($key, $class) {
                $items[$key] = [
                    'class' => $class
                ];

                return $items;
            },
            $priority
        );
    }

    public static function make()
    {
        return (new Notification());
    }

    /**
     * @param array|int|\Juzaweb\CMS\Models\User $users
     * @return $this
     */
    public function setUsers($users)
    {
        $userIds = [];
        if (is_numeric($users)) {
            $userIds[] = $users;
        } elseif (is_array($users) || $users instanceof \Illuminate\Database\Eloquent\Collection) {
            foreach ($users as $user) {
                if (is_numeric($user)) {
                    $userIds[] = $user;
                } elseif (is_a($user, User::class)) {
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

    public function setImage($image): static
    {
        $this->image = $image;
        return $this;
    }

    public function setMethod(array $methods): static
    {
        $this->method = $methods;

        return $this;
    }

    public function send()
    {
        $notification = ManualNotification::create(
            [
                'users' => implode(',', $this->users),
                'method' => implode(',', $this->method),
                'data' => [
                    'subject' => $this->subject,
                    'body' => $this->body,
                    'url' => $this->url,
                    'image' => $this->image,
                ],
            ]
        );

        switch (config('juzaweb.notification.method', 'sync')) {
            case 'sync':
                (new SendNotification($notification))->send();
                break;
            case 'queue':
                SendNotificationJob::dispatch($notification);
                break;
        }
    }
}

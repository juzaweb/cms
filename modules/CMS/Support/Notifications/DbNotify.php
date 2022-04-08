<?php

namespace Juzaweb\CMS\Support\Notifications;

use Illuminate\Notifications\Notification;

class DbNotify extends Notification
{
    protected $data;

    public function __construct($data)
    {
        $this->data = is_array($data) ? (object) $data : $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'subject' => $this->data->subject,
            'body' => $this->data->body,
            'url' => $this->data->url,
            'image' => $this->data->image,
        ];
    }
}

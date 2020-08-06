<?php

namespace App\Notifications;

use App\Channels\CustomMailChannel;
use App\Models\MyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SendNotification extends Notification
{
    use Queueable;
    
    protected $myNotification;
    
    public function __construct(MyNotification $myNotification)
    {
        $this->myNotification = $myNotification;
    }
    
    public function via($notifiable)
    {
        return [CustomMailChannel::class, 'database'];
    }
    
    public function toCustomMail($notifiable)
    {
        if (in_array($this->myNotification->type, [2, 3])) {
            return [
                'subject' => $this->myNotification->subject,
                'content' => $this->myNotification->content,
                'params' => json_encode([
                    'name' => $notifiable->name,
                    'email' => $notifiable->email
                ])
            ];
        }
        
        return false;
    }
    
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->myNotification->subject,
            'content' => $this->myNotification->content,
        ];
    }
}

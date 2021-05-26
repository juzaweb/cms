<?php
/**
 * MYMO CMS - TV Series & Movie Portal CMS Unlimited
 *
 * @package mymocms/mymocms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://github.com/mymocms/mymocms
 */

namespace Mymo\Core\Notifications;

use Mymo\Core\Channels\CustomMailChannel;
use Mymo\Core\Models\MyNotification;
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

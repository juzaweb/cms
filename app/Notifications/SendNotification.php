<?php

namespace App\Notifications;

use App\Models\EmailList;
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
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable)
    {
        if (in_array($this->myNotification->type, [2, 3])) {
            $mail = new EmailList();
            $mail->subject = $this->myNotification->subject;
            $mail->content = $this->myNotification->content;
            $mail->template_file = 'notification';
            $mail->emails = $notifiable->email;
            $mail->params = json_encode([
                'name' => $notifiable->name,
                'email' => $notifiable->email
            ]);
            return $mail->save();
        }
        return false;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->myNotification->subject,
            'content' => $this->myNotification->content,
        ];
    }
}

<?php

namespace App\Channels;

use App\Models\EmailList;
use Illuminate\Notifications\Notification;

class CustomMailChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toCustomMail($notifiable);
        if ($message) {
            $mail = new EmailList();
            $mail->subject = $message['subject'];
            $mail->content = $message['content'];
            $mail->emails = $notifiable->email;
            $mail->params = $message['params'];
            $mail->save();
        }
    }
}
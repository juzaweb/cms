<?php

namespace App\Listeners;

use App\Events\RegisterSuccess;
use App\Models\EmailList;

class RegisterSuccessListener
{
    public function __construct()
    {
    
    }
    
    public function handle(RegisterSuccess $event)
    {
        if (get_config('user_verification')) {
            $mail = new EmailList();
            $mail->template_file = 'user_verification';
            $mail->emails = $event->user->email;
            $mail->priority = 2;
            $mail->params = json_encode([
                'name' => $event->user->name,
                'email' => $event->user->email,
                'url' => '',
            ]);
            $mail->sendByTemplate();
        }
    }
}

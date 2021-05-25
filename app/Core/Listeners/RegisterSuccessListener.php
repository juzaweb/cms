<?php

namespace App\Core\Listeners;

use App\Core\Events\RegisterSuccess;
use App\Core\Models\Email\EmailList;
use App\Core\User;

class RegisterSuccessListener
{
    public function __construct()
    {
    
    }
    
    public function handle(RegisterSuccess $event)
    {
        if (get_config('user_verification')) {
            $user = User::where('email', $event->user->email)
                ->first(['verification_token']);
            
            $mail = new EmailList();
            $mail->emails = $event->user->email;
            $mail->priority = 2;
            $mail->params = json_encode([
                'name' => $event->user->name,
                'email' => $event->user->email,
                'url' => route('register.verification', [$user->verification_token]),
            ]);
            $mail->sendByTemplate('user_verification');
        }
    }
}
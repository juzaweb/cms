<?php

namespace App\Listeners;

use App\Events\RegisterSuccess;
use App\Models\EmailList;
use App\User;

class RegisterSuccessListener
{
    public function __construct()
    {
    
    }
    
    public function handle(RegisterSuccess $event)
    {
        if (get_config('user_verification')) {
            $user = User::where('email', $event->user->email)
                ->first();
            $token = generate_token($event->user->email);
            $user->update([
                'verification_token' => $token,
            ]);
            
            $mail = new EmailList();
            $mail->emails = $event->user->email;
            $mail->priority = 2;
            $mail->params = json_encode([
                'name' => $event->user->name,
                'email' => $event->user->email,
                'url' => route('register.verification', [$token]),
            ]);
            $mail->sendByTemplate('user_verification');
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Configs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoSendMail extends Command
{
    protected $signature = 'mail:auto';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        \Config::set('mail.host', Configs::getConfig('mail_host'));
        \Config::set('mail.driver', Configs::getConfig('mail_driver'));
        \Config::set('mail.port', Configs::getConfig('mail_port'));
        \Config::set('mail.username', Configs::getConfig('mail_username'));
        \Config::set('mail.password', Configs::getConfig('mail_password'));
        \Config::set('mail.from.name', Configs::getConfig('mail_from_name'));
        \Config::set('mail.from.address', Configs::getConfig('mail_from_address'));
    
        (new \Illuminate\Mail\MailServiceProvider(app()))->register();
        /*$transport = (new \Swift_SmtpTransport('host', 'port'))
            ->setEncryption(null)
            ->setUsername('username')
            ->setPassword('secret')
            ->setPort(587);
        $mailer = app(\Illuminate\Mail\Mailer::class);
        $mailer->setSwiftMailer(new \Swift_Mailer($transport));
    
        $mail = $mailer
            ->to('user@laravel.com')
            ->send(new OrderShipped);*/
    
        
        
        Mail::send('mail.default', [
            'content' => $content
        ], function ($message) use ($row, $emails, $subject) {
            //                $message->from('elearn@kienlongbank.com', 'Đào tạo');
            $message->to($emails)->subject($subject);
        });
    
        if (Mail::failures()) {
            var_dump(Mail::failures());
        }
    }
}

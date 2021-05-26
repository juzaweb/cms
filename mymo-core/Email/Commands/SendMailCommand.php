<?php

namespace Tadcms\EmailTemplate\Commands;

use Tadcms\EmailTemplate\Models\EmailList;
use Illuminate\Console\Command;
use Tadcms\EmailTemplate\SendEmailService;

class SendMailCommand extends Command
{
    protected $signature = 'email:send';
    
    protected $description = 'Send email command';
    
    /**
     * Use command to send email to avoid affecting the user experience
     * Get email list in email_lists table and send
     * All you need to do is save the email to be sent to the table email_lists
     * */
    public function handle()
    {
        if (config('email-template.method') != 'cron') {
            return;
        }

        $limit = 10;
        $send = 0;
        
        while (true) {
            $mail = EmailList::with(['template'])
                ->where('status', '=', 'pending')
                ->orderBy('priority', 'DESC')
                ->first();
            
            if (empty($mail)) {
                return;
            }
            
            if ((new SendEmailService($mail))->send()) {
                $this->info('Send mail successful: ' . $mail->id);
            } else {
                $this->error('Send mail error: ' . $mail->id);
            }
            
            $send++;
            
            if ($send >= $limit) {
                break;
            }
        }
    }
}

<?php

namespace Juzaweb\CMS\Console\Commands;

use Illuminate\Console\Command;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\CMS\Support\SendEmail;

class SendMailCommand extends Command
{
    protected $signature = 'email:send';

    /**
     * Use command to send email to avoid affecting the user experience
     * Get email list in email_lists table and send
     * All you need to do is save the email to be sent to the table email_lists
     */
    public function handle()
    {
        if (config('email.method') != 'cron') {
            return static::SUCCESS;
        }

        $limit = 10;
        $send = 0;

        while (true) {
            $mail = EmailList::with(['template'])
                ->where('status', '=', 'pending')
                ->orderBy('priority', 'DESC')
                ->first();

            if (empty($mail)) {
                return static::SUCCESS;
            }

            if ((new SendEmail($mail))->send()) {
                $this->info('Send mail successful: ' . $mail->id);
            } else {
                $this->error('Send mail error: ' . $mail->id);
            }

            $send++;

            if ($send >= $limit) {
                break;
            }
        }

        return static::SUCCESS;
    }
}

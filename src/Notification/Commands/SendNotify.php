<?php

namespace Mymo\Notification\Commands;

use Illuminate\Console\Command;
use Mymo\Notification\Models\ManualNotification;
use Mymo\Notification\SendNotification;

class SendNotify extends Command
{
    protected $signature = 'notify:send';
    
    protected $description = 'Send notify command';
    
    public function handle()
    {
        if (config('mymo.notification.method') != 'cron') {
            return;
        }

        $limit = 3;
        $count = 0;
        while ($count < $limit) {
            $notification = ManualNotification::where('status', '=', 2)
                ->first();
            if (empty($notification)) {
                break;
            }

            if ((new SendNotification($notification))->send()) {
                $this->info('Send notify successful: ' . $notification->id);
            } else {
                $this->error('Send notify error: ' . $notification->id);
            }

            $count ++;
        }
    }
}

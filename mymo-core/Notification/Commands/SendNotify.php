<?php

namespace Tadcms\Notification\Commands;

use Illuminate\Console\Command;
use Tadcms\Notification\Models\ManualNotification;
use Tadcms\Notification\SendNotification;

class SendNotify extends Command
{
    protected $signature = 'notify:send';
    
    protected $description = 'Send notify command';
    
    public function handle()
    {
        if (config('notification.method') != 'cron') {
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

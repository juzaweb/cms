<?php

namespace Mymo\Notification\Notifications;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Mymo\Email\EmailService;

/**
 * EmailNotification class
 *
 * @package    Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 */
class EmailNotification extends NotificationAbstract
{
    public function handle()
    {
        $emails = DB::table('users')
            ->whereIn('id', $this->users)
            ->pluck('email')
            ->toArray();

        (EmailService::make())
            ->withTemplate('notification')
            ->setEmails($emails)
            ->setParams([
                'subject' => Arr::get($this->notification->data, 'subject'),
                'body' => Arr::get($this->notification->data, 'body'),
                'url' => Arr::get($this->notification->data, 'url'),
                'image' => Arr::get($this->notification->data, 'image'),
            ])
            ->send();
    }
}

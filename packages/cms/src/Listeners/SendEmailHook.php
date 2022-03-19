<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/10/2021
 * Time: 2:50 PM
 */

namespace Juzaweb\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Juzaweb\Events\EmailHook;
use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\Support\Email;

class SendEmailHook implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param EmailHook $event
     * @return void
     */
    public function handle(EmailHook $event)
    {
        $params = $event->args['params'] ?? [];
        $to = $event->args['to'] ?? [];
        if (! is_array($to)) {
            $to = [$to];
        }

        $templates = EmailTemplate::where('email_hook', '=', $event->hook)
            ->get();

        foreach ($templates as $template) {
            Email::make()
                ->setEmails($to)
                ->withTemplate($template->code)
                ->setParams($params)
                ->send();
        }
    }
}

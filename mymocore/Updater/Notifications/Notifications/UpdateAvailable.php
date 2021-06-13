<?php

declare(strict_types=1);

namespace Mymo\Updater\Notifications\Notifications;

use Mymo\Updater\Events\UpdateAvailable as UpdateAvailableEvent;
use Mymo\Updater\Notifications\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

final class UpdateAvailable extends BaseNotification
{
    /**
     * @var UpdateAvailableEvent
     */
    protected $event;

    public function toMail(): MailMessage
    {
        return (new MailMessage())
            ->from(config('updater.notifications.mail.from.address', config('mail.from.address')), config('updater.notifications.mail.from.name', config('mail.from.name')))
            ->subject(config('app.name').': Update available');
    }

    public function setEvent(UpdateAvailableEvent $event)
    {
        $this->event = $event;

        return $this;
    }
}

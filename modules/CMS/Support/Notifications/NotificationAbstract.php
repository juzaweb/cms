<?php

namespace Juzaweb\CMS\Support\Notifications;

abstract class NotificationAbstract
{
    protected $notification;
    protected $users;
    /**
     * @param \Juzaweb\Backend\Models\ManualNotification $notification
     * */
    public function __construct($notification)
    {
        $this->notification = $notification;
        $this->users = explode(',', $this->notification->users);
    }

    abstract public function handle();
}

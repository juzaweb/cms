<?php

namespace Juzaweb\Notification;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class NotificationAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addAdminMenus']);
    }

    public function addAdminMenus()
    {
        HookAction::registerAdminPage(
            'notification',
            [
                'title' => trans('cms::app.notifications'),
                'menu' => [
                    'icon' => 'fa fa-bell',
                    'position' => 100
                ]
            ]
        );
    }
}

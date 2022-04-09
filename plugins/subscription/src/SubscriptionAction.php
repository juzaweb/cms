<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Subscription;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class SubscriptionAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::BACKEND_CALL_ACTION,
            [$this, 'addAdminMenu']
        );
    }

    public function addAdminMenu()
    {
        HookAction::addAdminMenu(
            trans('subr::content.subscription'),
            'subscription',
            [
                'icon' => 'fa fa-arrow-circle-up',
                'position' => 30,
            ]
        );

        HookAction::addAdminMenu(
            trans('subr::content.packages'),
            'subscription.packages',
            [
                'icon' => 'fa fa-arrow-circle-up',
                'position' => 1,
                'parent' => 'subscription',
            ]
        );

        HookAction::addAdminMenu(
            trans('subr::content.setting'),
            'subscription.setting',
            [
                'icon' => 'fa fa-cogs',
                'position' => 2,
                'parent' => 'subscription',
            ]
        );

        HookAction::addAdminMenu(
            trans('subr::content.histories'),
            'subscription.histories',
            [
                'icon' => 'fa fa-history',
                'position' => 2,
                'parent' => 'subscription',
            ]
        );
    }
}

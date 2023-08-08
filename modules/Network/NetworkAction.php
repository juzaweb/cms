<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\Network\Facades\Network;

class NetworkAction extends Action
{
    public function handle(): void
    {
        //$this->addAction(Action::BACKEND_INIT, [$this, 'registerMenus']);

        if (Network::isRootSite()) {
            $this->addAction('backend.menu_top', [$this, 'addMenuAdmin']);

            $this->addAction(
                Action::NETWORK_INIT,
                [$this, 'registerMasterAdminMenu']
            );
        }
    }

    public function addMenuAdmin(): void
    {
        echo e(view('network::components.menu_admin'));
    }

    public function registerMasterAdminMenu(): void
    {
        HookAction::addMasterAdminMenu(
            trans('cms::app.dashboard'),
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1,
            ]
        );

        HookAction::addMasterAdminMenu(
            trans('cms::app.network.sites'),
            'sites',
            [
                'icon' => 'fa fa-globe',
                'position' => 10,
            ]
        );

        HookAction::addMasterAdminMenu(
            trans('cms::app.themes'),
            'themes',
            [
                'icon' => 'fa fa-paint-brush',
                'position' => 40,
            ]
        );

        HookAction::addMasterAdminMenu(
            trans('cms::app.plugins'),
            'plugins',
            [
                'icon' => 'fa fa-plug',
                'position' => 45,
            ]
        );

        HookAction::addAdminMenu(
            'Log Viewer',
            'log-viewer',
            [
                'parent' => 'tools',
                'icon' => 'fa fa-history',
                'position' => 99,
                'turbolinks' => false,
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.email_logs'),
            'logs.email',
            [
                'icon' => 'fa fa-cogs',
                'position' => 51,
                'parent' => 'managements',
            ]
        );
    }

    public function registerMenus(): void
    {
        HookAction::addAdminMenu(
            trans('cms::app.network.domain_mapping'),
            'domains',
            [
                'icon' => 'fa fa-server',
                'position' => 20,
                'parent' => 'setting'
            ]
        );
    }
}

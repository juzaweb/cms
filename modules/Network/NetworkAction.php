<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
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
    public function handle()
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'registerMenus']);

        if (Network::isRootSite()) {
            $this->addAction(
                Action::NETWORK_INIT,
                [$this, 'registerMasterAdminMenu']
            );
        }
    }

    public function registerMasterAdminMenu(): void
    {
        HookAction::addMasterAdminMenu(
            trans('cms::app.dashboard'),
            'dashboard',
            [
                'icon' => 'fa fa-globe',
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

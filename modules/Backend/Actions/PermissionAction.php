<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Actions;

use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\User;

class PermissionAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::BACKEND_INIT,
            [$this, 'addAdminMenu']
        );

        $this->addAction(
            Action::PERMISSION_INIT,
            [$this, 'addPermissions']
        );

        $this->addAction(
            Action::BACKEND_USER_FORM_RIGHT,
            [$this, 'addRoleUserForm']
        );

        $this->addAction(
            Action::BACKEND_USER_AFTER_SAVE,
            [$this, 'saveRoleUser'],
            20,
            2
        );
    }

    public function saveRoleUser($data, User $model)
    {
        $roles = Arr::get($data, 'roles', []);

        $model->syncRoles($roles);
    }

    public function addRoleUserForm(User $model)
    {
        echo e(
            view(
                'cms::backend.role.components.role_users',
                compact('model')
            )
        );
    }

    public function addAdminMenu()
    {
        HookAction::addAdminMenu(
            trans('cms::app.roles'),
            'roles',
            [
                'icon' => 'fa fa-users',
                'position' => 45,
                'parent' => 'managements',
            ]
        );
    }

    public function addPermissions(): void
    {
        /*HookAction::registerResourcePermissions(
            'media',
            trans('cms::app.media')
        );
        */

        HookAction::registerResourcePermissions(
            'themes',
            trans('cms::app.theme')
        );

        HookAction::registerResourcePermissions(
            'plugins',
            trans('cms::app.plugin')
        );

        HookAction::registerResourcePermissions(
            'users',
            trans('cms::app.user')
        );

        HookAction::registerResourcePermissions(
            'email_templates',
            trans('cms::app.email_template')
        );

        /*HookAction::registerResourcePermissions(
            'menus',
            trans('cms::app.menu')
        );*/

        HookAction::registerResourcePermissions(
            'roles',
            trans('cms::app.role')
        );
    }
}

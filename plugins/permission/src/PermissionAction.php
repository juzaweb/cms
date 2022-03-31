<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Permission;

use Illuminate\Support\Arr;
use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Models\User;

class PermissionAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::BACKEND_CALL_ACTION,
            [$this, 'addAdminMenu']
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
        echo e(view(
            'perm::backend.role.components.role_users',
            compact('model')
        ));
    }

    public function addAdminMenu()
    {
        HookAction::addAdminMenu(
            trans('perm::content.permissions'),
            'roles',
            [
                'icon' => 'fa fa-user-circle-o',
                'position' => 90,
            ]
        );
    }
}

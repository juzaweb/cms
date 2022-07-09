<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Permission;
use Juzaweb\CMS\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Http\Datatables\RoleDatatable;
use Juzaweb\Backend\Models\Role;

class RoleController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
        afterSave as tAfterSave;
    }

    protected string $viewPrefix = 'cms::backend.role';

    public function __construct()
    {
        do_action(Action::PERMISSION_INIT);
    }

    protected function getDataTable(...$params): DataTable
    {
        return new RoleDatatable();
    }

    protected function validator(array $attributes, ...$params): \Illuminate\Contracts\Validation\Validator
    {
        $permissions = HookAction::getPermissions()
            ->pluck('name')
            ->toArray();

        return Validator::make(
            $attributes,
            [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string|max:200',
                'permissions' => 'nullable|array',
                'permissions.*' => [
                    'nullable',
                    Rule::in($permissions)
                ],
            ]
        );
    }

    protected function afterSave($data, Role $model, ...$params)
    {
        $permissions = Arr::get($data, 'permissions', []);
        $exists = Permission::whereIn('name', $permissions)
            ->get(['name'])
            ->pluck('name')
            ->toArray();

        $permissionData = HookAction::getPermissions()
            ->whereIn(
                'name',
                collect($permissions)
                    ->filter(
                        function ($item) use ($exists) {
                            return !in_array($item, $exists);
                        }
                    )
                    ->toArray()
            );

        foreach ($permissionData as $item) {
            Permission::create(
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                ]
            );
        }

        $model->syncPermissions($permissions);
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        $data['groups'] = $this->getPermissionGroups();
        return $data;
    }

    protected function getModel(...$params): string
    {
        return Role::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('cms::app.roles');
    }

    protected function getPermissionGroups(): \Illuminate\Support\Collection
    {
        $permissions = HookAction::getPermissions();
        $groups = HookAction::getPermissionGroups();

        foreach ($permissions as $key => $item) {
            if ($group = $item->get('group')) {
                $group = $groups->get($group);
                $pers = $group->get('permissions', []);
                $pers[$key] = $item;
                $group->put('permissions', $pers);
                $groups[$group->get('key')] = $group;
            }
        }

        return $groups;
    }
}

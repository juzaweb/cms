<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Juzaweb\Backend\Models\Permission;
use Juzaweb\Backend\Models\PermissionGroup;
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

    protected $viewPrefix = 'cms::backend.role';

    protected function getDataTable(...$params)
    {
        return new RoleDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        $validator = Validator::make(
            $attributes,
            [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string|max:200',
                'permissions' => 'nullable|array',
                'permissions.*' => [
                    'nullable',
                    Rule::modelExists(Permission::class, 'name')
                ],
            ]
        );

        return $validator;
    }

    protected function afterSave($data, Role $model, ...$params)
    {
        $permissions = Arr::get($data, 'permissions', []);
        $model->syncPermissions($permissions);
    }

    protected function getDataForForm($model, ...$params)
    {
        $data = $this->DataForForm($model);
        $data['groups'] = $this->getPermissionGroups();
        return $data;
    }

    protected function getModel(...$params)
    {
        return Role::class;
    }

    protected function getTitle(...$params)
    {
        return trans('cms::app.roles');
    }

    protected function getPermissionGroups()
    {
        $plugins = array_keys(get_config('plugin_statuses', []));
        $query = PermissionGroup::with(['permissions']);
        $query->where(
            function (Builder $q) use ($plugins) {
                $q->whereNull('plugin');
                $q->orWhereIn('plugin', $plugins);
            }
        );
        return $query->get();
    }
}

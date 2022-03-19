<?php

namespace Juzaweb\Permission\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Permission\Models\PermissionGroup;
use Juzaweb\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Permission\Http\Datatables\RoleDatatable;
use Juzaweb\Permission\Models\Role;

class RoleController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
        afterSave as tAfterSave;
    }

    protected $viewPrefix = 'perm::backend.role';

    protected function getDataTable(...$params)
    {
        return new RoleDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        $validator = Validator::make($attributes, [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|exists:permissions,name',
        ]);

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

    protected function getModel()
    {
        return Role::class;
    }

    protected function getTitle(...$params)
    {
        return trans('perm::content.roles');
    }

    private function getPermissionGroups()
    {
        $plugins = array_keys(get_config('plugin_statuses', []));
        $query = PermissionGroup::with(['permissions']);
        $query->where(function (Builder $q) use ($plugins) {
            $q->whereNull('plugin');
            $q->orWhereIn('plugin', $plugins);
        });
        return $query->get();
    }
}

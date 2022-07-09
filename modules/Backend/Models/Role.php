<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Support\Arr;
use Juzaweb\CMS\Models\Role as BaseRole;
use Juzaweb\CMS\Traits\ResourceModel;

/**
 * Juzaweb\Backend\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\CMS\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends BaseRole
{
    use ResourceModel;

    protected $table = 'roles';

    public function attributeLabel($key)
    {
        $label = Arr::get($this->attributeLabels(), $key);
        if (empty($label)) {
            $label = trans("cms::app.{$key}");
        }

        return $label;
    }

    public function attributeLabels()
    {
        return [];
    }
}

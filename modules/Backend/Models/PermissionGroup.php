<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\PermissionGroup
 *
 * @property int $id
 * @property string $name
 * @property string|null $plugin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup wherePlugin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereUpdatedAt($value)
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereDescription($value)
 * @mixin \Eloquent
 */
class PermissionGroup extends Model
{
    protected $table = 'permission_groups';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }
}

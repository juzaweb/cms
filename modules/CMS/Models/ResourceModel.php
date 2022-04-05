<?php

namespace Juzaweb\Models;

/**
 * Juzaweb\Models\ResourceModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResourceModel whereFilter($params = [])
 * @mixin \Eloquent
 */
class ResourceModel extends Model
{
    use \Juzaweb\Traits\ResourceModel;
}

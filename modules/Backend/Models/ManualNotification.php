<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Backend\Models\ManualNotification
 *
 * @property int $id
 * @property string|null $method
 * @property string $users
 * @property array $data
 * @property int $status
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereUsers($value)
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|ManualNotification whereSiteId($value)
 * @mixin \Eloquent
 */
class ManualNotification extends Model
{
    const STATUS_PENDING = 2;
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 0;

    protected $table = 'manual_notifications';

    protected $fillable = [
        'method',
        'users',
        'data',
        'status',
        'error'
    ];

    public $casts = [
        'data' => 'array',
    ];
}

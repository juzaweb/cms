<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Backend\Models\Notification
 *
 * @property int $id
 * @property string $type
 * @property array $data
 * @property string|null $read_at
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSiteId($value)
 */
class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'type',
        'data',
        'read_at',
        'notifiable_type',
        'notifiable_id',
    ];

    public $casts = [
        'data' => 'array',
    ];
}

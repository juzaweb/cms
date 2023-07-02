<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;

/**
 * Juzaweb\Backend\Models\Notification
 *
 * @property int $id
 * @property string $type
 * @property string $url
 * @property string $subject
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
 * @property int|null $site_id
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSiteId($value)
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection|static[] all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection|static[] get($columns = ['*'])
 * @method static Builder|DatabaseNotification read()
 * @method static Builder|DatabaseNotification unread()
 * @mixin \Eloquent
 */
class Notification extends DatabaseNotification
{
    use QueryCacheable;

    public string $cachePrefix = 'notifications_';
    protected static bool $flushCacheOnUpdate = true;

    protected $fillable = [
        'id',
        'type',
        'data',
        'read_at',
        'notifiable_type',
        'notifiable_id',
    ];

    public $appends = [
        'subject',
        'url',
    ];

    public function getSubjectAttribute()
    {
        return Arr::get($this->data, 'subject');
    }

    public function getUrlAttribute()
    {
        return Arr::get($this->data, 'url');
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'notifications',
        ];
    }
}

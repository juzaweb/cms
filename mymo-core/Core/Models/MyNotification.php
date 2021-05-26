<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\MyNotification
 *
 * @property int $id
 * @property string $name
 * @property string|null $users
 * @property string $subject
 * @property string $content
 * @property string $url
 * @property int $type 1: Notify, 2: Email, 3: All
 * @property int $status 0: Cancel, 1: Sended, 2: Sending, 3: Pause
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\MyNotification whereUsers($value)
 * @mixin \Eloquent
 */
class MyNotification extends Model
{
    protected $table = 'my_notification';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'subject',
        'content',
        'url',
        'type',
    ];
}

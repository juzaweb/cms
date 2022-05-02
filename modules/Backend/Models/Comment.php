<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;

/**
 * Juzaweb\Backend\Models\Comment
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $email
 * @property string|null $name
 * @property string|null $website
 * @property string $content
 * @property int $object_id Post type ID
 * @property string $object_type Post type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Juzaweb\Backend\Models\Post $post
 * @property-read User|null $user
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereApproved()
 * @method static Builder|Comment whereContent($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereEmail($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereName($value)
 * @method static Builder|Comment whereObjectId($value)
 * @method static Builder|Comment whereObjectType($value)
 * @method static Builder|Comment whereStatus($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 * @method static Builder|Comment whereWebsite($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 * @method static Builder|Comment whereSiteId($value)
 */
class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'email',
        'name',
        'website',
        'content',
        'status',
        'object_type',
        'user_id',
    ];

    protected $touches = ['post'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'object_id', 'id');
    }

    public function postType()
    {
        $postType = HookAction::getPostTypes($this->object_type);

        return $postType->get('model')::find($this->object_id);
    }

    public function scopeWhereApproved(Builder $builder): Builder
    {
        return $builder->where('status', '=', 'approved');
    }

    public function getUserName(): ?string
    {
        return $this->user ? $this->user->name : $this->name;
    }

    public function getAvatar(): string
    {
        if ($this->user) {
            return $this->user->getAvatar();
        }

        return asset('jw-styles/juzaweb/images/avatar.png');
    }

    public function getUpdatedDate($format = JW_DATE_TIME): string
    {
        return jw_date_format($this->updated_at, $format);
    }

    public function getCreatedDate($format = JW_DATE_TIME): string
    {
        return jw_date_format($this->updated_at, $format);
    }

    public static function allStatuses()
    {
        return apply_filters(
            'comment.statuses',
            [
                'approved' => trans('cms::app.approved'),
                'deny' => trans('cms::app.deny'),
                'pending' => trans('cms::app.pending'),
                'trash' => trans('cms::app.trash'),
            ]
        );
    }
}

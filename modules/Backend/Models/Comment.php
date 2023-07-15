<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Juzaweb\Backend\Models\Post $post
 * @property-read User|null $user
 * @method static Builder|Comment with(array $with)
 * @method static Builder|Comment query()
 * @method Builder|Comment newModelQuery()
 * @method Builder|Comment newQuery()
 * @method Builder|Comment query()
 * @method Builder|Comment whereApproved()
 * @method Builder|Comment whereContent($value)
 * @method Builder|Comment whereCreatedAt($value)
 * @method Builder|Comment whereEmail($value)
 * @method Builder|Comment whereId($value)
 * @method Builder|Comment whereName($value)
 * @method Builder|Comment whereObjectId($value)
 * @method Builder|Comment whereObjectType($value)
 * @method Builder|Comment whereStatus($value)
 * @method Builder|Comment whereUpdatedAt($value)
 * @method Builder|Comment whereUserId($value)
 * @method Builder|Comment whereWebsite($value)
 * @property int|null $site_id
 * @method Builder|Comment whereSiteId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use QueryCacheable;

    const STATUS_APPROVED = 'approved';

    public string $cachePrefix = 'comments_';

    protected $table = 'comments';

    protected $fillable = [
        'email',
        'name',
        'website',
        'content',
        'status',
        'object_id',
        'object_type',
        'user_id',
    ];

    protected $touches = ['post'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
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

    protected function getCacheBaseTags(): array
    {
        return [
            'comments',
        ];
    }
}

<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Models\Model;
use Juzaweb\Models\User;

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

    public function scopeWhereApproved(Builder $builder)
    {
        return $builder->where('status', '=', 'approved');
    }

    public function getUserName()
    {
        return $this->user ? $this->user->name : $this->name;
    }

    public function getAvatar()
    {
        if ($this->user) {
            return $this->user->getAvatar();
        }

        return asset('jw-styles/juzaweb/styles/images/avatar.png');
    }

    public function getUpdatedDate($format = JW_DATE_TIME)
    {
        return jw_date_format($this->updated_at, $format);
    }

    public function getCreatedDate($format = JW_DATE_TIME)
    {
        return jw_date_format($this->updated_at, $format);
    }

    public static function allStatuses()
    {
        return apply_filters('comment.statuses', [
            'approved' => trans('cms::app.approved'),
            'deny' => trans('cms::app.deny'),
            'pending' => trans('cms::app.pending'),
            'trash' => trans('cms::app.trash'),
        ]);
    }
}

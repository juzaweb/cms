<?php

namespace Mymo\PostType\Models;

use Illuminate\Database\Eloquent\Model;
use Mymo\Core\Models\User;
use Mymo\PostType\PostType;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'email',
        'name',
        'website',
        'content',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function postType()
    {
        $postType = PostType::getPostTypes($this->object_type);
        return $this->belongsTo($postType->get('model'), 'object_id', 'id')->where('object_type', '=', $this->object_type);
    }

    public function whereActive($builder)
    {
        return $builder->where('status', '=', 'approved');
    }
}

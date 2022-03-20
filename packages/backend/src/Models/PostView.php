<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\Models\Model;

class PostView extends Model
{
    protected $table = 'post_views';
    protected $fillable = [
        'views',
        'day',
        'post_id',
    ];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}

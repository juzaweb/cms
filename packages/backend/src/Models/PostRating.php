<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\Models\Model;

class PostRating extends Model
{
    protected $table = 'post_ratings';

    protected $fillable = [
        'star',
        'client_ip',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}

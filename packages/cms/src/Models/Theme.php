<?php

namespace Juzaweb\Models;

use Juzaweb\Backend\Models\Post;

class Theme extends Post
{
    //protected $connection = 'pgsql';
    protected $postType = 'themes';
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'slug',
        'status',
    ];

    public static function hasTheme($theme)
    {
        return static::where('slug', '=', $theme)
            ->first();
    }
}

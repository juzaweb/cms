<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Mymo\Core\Translatable\Translatable;
use Mymo\Repository\Traits\TransformableTrait;
use Mymo\Core\Translatable\Contracts\Translatable as TranslatableContract;

class Post extends Model implements TranslatableContract
{
    use TransformableTrait, Translatable;

    protected $fillable = [
        'status',
    ];

    public $translatedAttributes = [
        'title',
        'content',
        'thumbnail',
        'slug'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function metas()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'id');
    }

    public function taxonomies()
    {
        return $this->belongsToMany('Tadcms\System\Models\Taxonomy', 'term_taxonomies', 'term_id', 'taxonomy_id');
    }
}

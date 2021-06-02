<?php

namespace Mymo\PostType\Models;

use Illuminate\Database\Eloquent\Model;
use Mymo\Core\Translatable\Translatable;
use Mymo\Core\Translatable\Contracts\Translatable as TranslatableContract;

class Taxonomy extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'taxonomies';
    protected $slugSource = 'name';
    protected $fillable = [
        'type',
        'taxonomy',
        'type',
        'parent_id',
        'total_post'
    ];

    public $translatedAttributes = [
        'name',
        'description',
        'thumbnail',
        'slug'
    ];

    public function parent()
    {
        return $this->belongsTo(Taxonomy::class, 'parent_id', 'id');
    }

    public function childrens()
    {
        return $this->hasMany(Taxonomy::class, 'parent_id', 'id');
    }
}

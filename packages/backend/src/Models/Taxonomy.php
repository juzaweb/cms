<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\Backend\Database\Factories\TaxonomyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Juzaweb\Traits\ModelCache;
use Juzaweb\Traits\TaxonomyModel;
use Juzaweb\Models\Model;

class Taxonomy extends Model
{
    use TaxonomyModel, HasFactory, ModelCache;

    public $cachePrefix = 'taxonomies_';

    public $cacheTags = ['taxonomies_'];

    protected $table = 'taxonomies';

    protected $slugSource = 'name';

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'slug',
        'taxonomy',
        'post_type',
        'parent_id',
        'total_post',
    ];

    /**
     * Create Builder for frontend
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\Resource
     */
    public static function selectFrontendBuilder()
    {
        $builder = self::query()
            ->cacheFor(3600);

        return $builder;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TaxonomyFactory::new();
    }

    public function menuItems()
    {
        return $this->hasMany(
            MenuItem::class,
            'model_id',
            'id'
        )
            ->where(
                'model_class',
                '=',
                'Juzaweb\\Models\\Taxonomy'
            );
    }
}

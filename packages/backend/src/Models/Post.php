<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Juzaweb\Backend\Database\Factories\PostFactory;
use Juzaweb\Models\Model;
use Juzaweb\Traits\ModelCache;
use Juzaweb\Traits\PostTypeModel;

class Post extends Model
{
    use PostTypeModel, HasFactory, ModelCache;

    const STATUS_PUBLISH = 'publish';

    public $cachePrefix = 'posts_';

    public $cacheTags = ['posts_tags'];

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'status',
        'views',
        'thumbnail',
        'slug',
        'type',
        'json_metas',
        'json_taxonomies',
        'rating',
        'total_rating',
    ];

    protected $searchFields = [
        'title',
    ];

    protected $casts = [
        'json_metas' => 'array',
        'json_taxonomies' => 'array',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PostFactory::new();
    }

    public function categories()
    {
        return $this->taxonomies()
            ->where('taxonomy', '=', 'categories');
    }

    public function tags()
    {
        return $this->taxonomies()->where('taxonomy', '=', 'tags');
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
                'Juzaweb\\Models\\Post'
            );
    }

    public function postViews()
    {
        return $this->hasMany(PostView::class, 'post_id', 'id');
    }

    public function postRatings()
    {
        return $this->hasMany(PostRating::class, 'post_id', 'id');
    }

    public function getTotalRating()
    {
        return $this->postRatings()->count(['id']);
    }

    public function getStarRating()
    {
        $total = $this->postRatings()->sum('star');
        $count = $this->getTotalRating();

        if ($count <= 0) {
            return 0;
        }

        return round($total * 5 / ($count * 5), 2);
    }

    /*public function toFeedItem(): FeedItem
    {
        $name = $this->getCreatedByName();
        $updated = $this->updated_at ?: now();
        if (empty($name)) {
            $name = 'Admin';
        }

        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($updated)
            ->link($this->getLink())
            ->authorName($name);
    }*/
}

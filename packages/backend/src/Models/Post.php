<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Juzaweb\Backend\Database\Factories\PostFactory;
use Juzaweb\Models\Model;
use Juzaweb\Traits\ModelCache;
use Juzaweb\Traits\PostTypeModel;

/**
 * Juzaweb\Backend\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $content
 * @property string $status
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Taxonomy[] $taxonomies
 * @property-read int|null $taxonomies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublish()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomy($taxonomy)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomyIn($taxonomies)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViews($value)
 * @property string|null $description
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Juzaweb\Models\User|null $createdBy
 * @property-read \Juzaweb\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedBy($value)
 * @property string $type
 * @property int|null $site_id
 * @method static \Juzaweb\Backend\Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostMeta[] $metas
 * @property-read int|null $metas_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMeta($key, $value)
 * @property array|null $json_metas
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereJsonMetas($value)
 * @property array|null $json_taxonomies
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereJsonTaxonomies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSearch($params)
 * @property float $rating
 * @property int $total_rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\MenuItem[] $menuItems
 * @property-read int|null $menu_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostRating[] $postRatings
 * @property-read int|null $post_ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostView[] $postViews
 * @property-read int|null $post_views_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTotalRating($value)
 * @property string|null $lang
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLang($value)
 */
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

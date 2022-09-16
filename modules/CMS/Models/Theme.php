<?php

namespace Juzaweb\CMS\Models;

use Juzaweb\Backend\Models\Post;

/**
 * Juzaweb\CMS\Models\Theme
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string $slug
 * @property string|null $description
 * @property string|null $content
 * @property string $status
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $type
 * @property array|null $json_metas
 * @property array|null $json_taxonomies
 * @property float $rating
 * @property int $total_rating
 * @property int $total_comment
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Juzaweb\CMS\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostMeta[] $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\Taxonomy[] $taxonomies
 * @property-read int|null $taxonomies_count
 * @property-read \Juzaweb\CMS\Models\User|null $updatedBy
 * @method static \Juzaweb\CMS\Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme query()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereFilter($params = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereJsonMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereJsonTaxonomies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMeta($key, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublish()
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSearch($params)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomy($taxonomy)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTaxonomyIn($taxonomies)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereTotalComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereTotalRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereViews($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\MenuItem[] $menuItems
 * @property-read int|null $menu_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostRating[] $postRatings
 * @property-read int|null $post_ratings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\PostView[] $postViews
 * @property-read int|null $post_views_count
 * @property int|null $site_id
 * @property string|null $locale
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereMetaIn($key, $values)
 * @method static \Illuminate\Database\Eloquent\Builder|Theme whereSiteId($value)
 */
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

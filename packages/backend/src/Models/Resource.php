<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Models\Model;
use Juzaweb\Traits\ModelCache;

/**
 * Juzaweb\Backend\Models\Resource
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $thumbnail
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $site_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Resource[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\ResourceMeta[] $metas
 * @property-read int|null $metas_count
 * @property-read Resource $parent
 * @property-read \Juzaweb\Backend\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resource whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $type
 * @property array|null $json_metas
 * @property int|null $post_id
 * @property int|null $parent_id
 * @property int $display_order
 * @method static Builder|Resource whereDisplayOrder($value)
 * @method static Builder|Resource whereJsonMetas($value)
 * @method static Builder|Resource whereParentId($value)
 * @method static Builder|Resource wherePostId($value)
 * @method static Builder|Resource wherePublish()
 * @method static Builder|Resource whereType($value)
 */
class Resource extends Model
{
    use ModelCache;

    public $cachePrefix = 'resources_';

    public $cacheTags = ['resources_'];

    protected $table = 'resources';

    protected $fillable = [
        'name',
        'type',
        'thumbnail',
        'description',
        'status',
        'post_id',
        'json_metas',
        'parent_id',
        'display_order',
    ];

    protected $casts = [
        'json_metas' => 'array'
    ];

    public static function getStatuses()
    {
        return [
            'publish' => trans('cms::app.publish'),
            'draft' => trans('cms::app.draft'),
            'trash' => trans('cms::app.trash'),
        ];
    }

    /**
     * Create Builder for frontend
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\Resource
     */
    public static function selectFrontendBuilder()
    {
        $builder = self::query()
            ->cacheFor(3600)
            ->wherePublish();

        return $builder;
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function metas()
    {
        return $this->hasMany(ResourceMeta::class, 'resource_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Resource::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Resource::class, 'parent_id', 'id');
    }

    public function scopeWherePublish(Builder $builder)
    {
        return $builder->where('status', '=', 'publish');
    }

    public function syncMetas(array $data = [])
    {
        $metas = [];
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $val = json_encode($val);
            }

            $this->metas()->updateOrCreate([
                'meta_key' => $key
            ], [
                'meta_value' => $val
            ]);

            $metas[$key] = $val;
        }

        $this->update([
            'json_metas' => $metas
        ]);

        $this->metas()
            ->whereNotIn('meta_key', array_keys($data))
            ->delete();
    }

    public function getMeta($key, $default = null)
    {
        return Arr::get($this->json_metas, $key, $default);
    }

    public function getFieldName()
    {
        return 'name';
    }
}

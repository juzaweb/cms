<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\Resource
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $thumbnail
 * @property string|null $description
 * @property array|null $json_metas
 * @property string $status
 * @property int|null $post_id
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $display_order
 * @property-read \Illuminate\Database\Eloquent\Collection|Resource[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Juzaweb\Backend\Models\ResourceMeta[] $metas
 * @property-read int|null $metas_count
 * @property-read Resource|null $parent
 * @property-read \Juzaweb\Backend\Models\Post|null $post
 * @method static Builder|Resource newModelQuery()
 * @method static Builder|Resource newQuery()
 * @method static Builder|Resource query()
 * @method static Builder|Resource whereCreatedAt($value)
 * @method static Builder|Resource whereDescription($value)
 * @method static Builder|Resource whereDisplayOrder($value)
 * @method static Builder|Resource whereId($value)
 * @method static Builder|Resource whereJsonMetas($value)
 * @method static Builder|Resource whereName($value)
 * @method static Builder|Resource whereParentId($value)
 * @method static Builder|Resource wherePostId($value)
 * @method static Builder|Resource wherePublish()
 * @method static Builder|Resource whereStatus($value)
 * @method static Builder|Resource whereThumbnail($value)
 * @method static Builder|Resource whereType($value)
 * @method static Builder|Resource whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 * @method static Builder|Resource whereSiteId($value)
 */
class Resource extends Model
{
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

            $this->metas()->updateOrCreate(
                [
                    'meta_key' => $key
                ],
                [
                    'meta_value' => $val
                ]
            );

            $metas[$key] = $val;
        }

        $this->update(
            [
                'json_metas' => $metas
            ]
        );

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

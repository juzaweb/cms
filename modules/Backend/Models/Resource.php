<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\UseSlug;
use Juzaweb\CMS\Traits\UseUUIDColumn;

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
 * @method static Builder|Resource whereMeta($key, $value)
 * @method static Builder|Resource orWhereMeta($key, $value)
 * @property int|null $site_id
 * @property string|null $slug
 * @method static Builder|Resource whereSiteId($value)
 * @method static Builder|Resource whereSlug($value)
 * @property string|null $uuid
 * @method static Builder|Resource whereUuid($value)
 * @mixin \Eloquent
 */
class Resource extends Model
{
    use UseSlug, UseUUIDColumn;

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
        'slug',
    ];

    protected $casts = [
        'json_metas' => 'array',
    ];

    public static function getStatuses(): array
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
     * @return Builder
     */
    public static function selectFrontendBuilder(): Builder
    {
        return self::query()->wherePublish();
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function metas(): HasMany
    {
        return $this->hasMany(ResourceMeta::class, 'resource_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Resource::class, 'parent_id', 'id');
    }

    public function scopeWherePublish(Builder $builder): Builder
    {
        return $builder->where('status', '=', 'publish');
    }

    public function scopeWhereMeta(Builder $builder, $key, $value = null): Builder
    {
        return $builder->whereHas(
            'metas',
            fn ($q) => $q->where('meta_key', $key)->where('meta_value', $value)
        );
    }

    public function scopeOrWhereMeta(Builder $builder, $key, $value = null): Builder
    {
        return $builder->orWhereHas(
            'metas',
            fn ($q) => $q->where('meta_key', $key)->where('meta_value', $value)
        );
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

    public function syncMetasWithoutDetaching(array $data = [])
    {
        $metas = $this->json_metas;
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
    }

    public function getMetas(): ?array
    {
        return $this->json_metas;
    }

    public function setMeta($key, $value): void
    {
        $metas = $this->getMetas();

        $this->metas()->updateOrCreate(
            [
                'meta_key' => $key
            ],
            [
                'meta_value' => is_array($value) ? json_encode($value) : $value
            ]
        );

        $metas[$key] = $value;

        $this->update(
            [
                'json_metas' => $metas
            ]
        );
    }

    public function getMeta($key, $default = null): string|array|null
    {
        return Arr::get($this->json_metas, $key, $default);
    }

    public function getFieldName(): string
    {
        return 'name';
    }
}

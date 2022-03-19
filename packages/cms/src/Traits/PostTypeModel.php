<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/8/2021
 * Time: 8:08 PM
 */

namespace Juzaweb\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Models\PostMeta;
use Juzaweb\Backend\Models\Taxonomy;

/**
 * @method Builder wherePublish()
 * @method Builder whereTaxonomy($taxonomy)
 * @method Builder whereTaxonomyIn($taxonomies)
 * @method Builder whereFilter(array $params)
 * @method Builder whereMeta($key, $val)
 */
trait PostTypeModel
{
    use ResourceModel;
    use UseSlug;
    use UseThumbnail;
    use UseChangeBy;
    use UseDescription;

    /**
     * Create Builder for frontend
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Juzaweb\Backend\Models\Post
     */
    public static function selectFrontendBuilder()
    {
        $builder = self::with([
                'createdBy' => function ($q) {
                    $q->cacheFor(3600);
                },
                'taxonomies' => function ($q) {
                    $q->cacheFor(3600);
                },
            ])
            ->cacheFor(3600)
            ->select([
                'id',
                'title',
                'description',
                'thumbnail',
                'slug',
                'views',
                'type',
                'status',
                'created_by',
                'json_metas',
            ])
            ->wherePublish();

        $builder = apply_filters('selectFrontendBuilder', $builder);

        return $builder;
    }

    /**
     * Create Builder for frontend
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function createFrontendBuilder()
    {
        $builder = self::with([
            'createdBy',
            'taxonomies',
        ])
            ->wherePublish();

        $builder = apply_filters('createFrontendBuilder', $builder);

        return $builder;
    }

    public static function getStatuses($type = 'posts')
    {
        $statuses = [
            'publish' => trans('cms::app.publish'),
            'private' => trans('cms::app.private'),
            'draft' => trans('cms::app.draft'),
            'trash' => trans('cms::app.trash'),
        ];

        return apply_filters($type . '.statuses', $statuses);
    }

    public function attributeLabels()
    {
        return [
            'title' => trans('cms::app.title'),
            'content' => trans('cms::app.content'),
            'status' => trans('cms::app.status'),
            'slug' => trans('cms::app.slug'),
            'thumbnail' => trans('cms::app.thumbnail'),
            'views' => trans('cms::app.views'),
        ];
    }

    public function taxonomies()
    {
        return $this->belongsToMany(Taxonomy::class, 'term_taxonomies', 'term_id', 'taxonomy_id')
            ->withPivot(['term_type']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id');
    }

    public function metas()
    {
        return $this->hasMany(PostMeta::class, 'post_id', 'id');
    }

    public function getMeta($key, $default = null)
    {
        return $this->json_metas[$key] ?? $default;
    }

    public function getMetas()
    {
        return $this->json_metas;
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeWhereFilter($builder, $params = [])
    {
        if ($keyword = Arr::get($params, 'q')) {
            $keyword = trim($keyword);
            $builder->where(function (Builder $q) use ($keyword) {
                $q->where('title', 'ilike', '%'.$keyword.'%');
                $q->orWhere('description', 'ilike', '%'.$keyword.'%');
            });
        }

        if ($status = Arr::get($params, 'status')) {
            $builder->where('status', '=', $status);
        }

        if ($type = Arr::get($params, 'type')) {
            $builder->where('type', '=', $type);
            $taxonomies = HookAction::getTaxonomies($type);

            foreach ($taxonomies as $key => $taxonomy) {
                $ids = Arr::get($params, $key, []);
                if (! is_array($ids)) {
                    $ids = [$ids];
                }

                $ids = array_filter(
                    $ids,
                    function ($item) {
                        return !empty($item);
                    }
                );

                if ($ids) {
                    $builder->whereTaxonomyIn($ids);
                }
            }
        }

        if ($metas = Arr::get($params, 'meta')) {
            foreach ($metas as $key => $val) {
                if (is_null($metas[$key])) {
                    continue;
                }

                $builder->whereMeta($key, $val);
            }
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param string $key
     * @param string $value
     *
     * @return Builder
     */
    public function scopeWhereMeta($builder, $key, $value)
    {
        return $builder->whereHas('metas', function (
            Builder $q
        ) use (
            $key,
            $value
        ) {
            $q->where('meta_key', '=', $key);
            if (is_array($value)) {
                $q->whereIn('meta_value', $value);
            } else {
                $q->where('meta_value', '=', $value);
            }
        });
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeWhereSearch($builder, $params)
    {
        $builder->whereFilter($params);

        if ($sort = Arr::get($params, 'sort')) {
            switch ($sort) {
                case 'latest':
                    $builder->orderBy('id', 'DESC');
                    break;
                case 'top_views':
                    $builder->orderBy('views', 'DESC');
                    break;
                case 'new_update':
                    $builder->orderBy('updated_at', 'DESC');
                    break;
            }
        }

        $builder = apply_filters(
            'frontend.search_query',
            $builder,
            $params
        );

        return $builder;
    }

    /**
     * Get taxonomies by taxonomy
     *
     * @param string $taxonomy
     * @param int $limit
     * @param bool $tree
     * @return Collection
     */
    public function getTaxonomies(
        $taxonomy = null,
        $limit = null,
        $tree = false
    ) {
        $taxonomies = $this->taxonomies;

        if ($taxonomy) {
            $taxonomies = $taxonomies->where('taxonomy', $taxonomy);
        }

        if ($tree) {
            $taxonomies = $taxonomies->orderBy('level', 'ASC');
        }

        if ($limit) {
            $taxonomies = $taxonomies->take($limit);
        }

        return $taxonomies;
    }

    /**
     * Get Related Posts
     *
     * @param int $limit
     * @param string $taxonomy
     * @return Collection
     */
    public function getRelatedPosts($limit = 5, $taxonomy = null)
    {
        $ids = $this->getTaxonomies($taxonomy)->pluck('id')->toArray();

        return self::whereHas('taxonomies', function (Builder $q) use ($ids) {
            $q->whereIn("{$q->getModel()->getTable()}.id", $ids);
        })
            ->where('id', '!=', $this->id)
            ->take($limit)
            ->get();
    }

    /**
     * @param array $attributes
     * @throws \Exception
     */
    public function syncTaxonomies(array $attributes)
    {
        if (empty($this->type)) {
            throw new \Exception('Cannot find Type in post.');
        }

        $taxonomies = HookAction::getTaxonomies($this->type);
        foreach ($taxonomies as $taxonomy) {
            $this->syncTaxonomy(
                $taxonomy->get('taxonomy'),
                $attributes,
                $this->type
            );
        }

        $this->update([
            'json_taxonomies' => TaxonomyResource::collection(
                $this->taxonomies()->get()
            )->toArray(request())
        ]);
    }

    public function syncTaxonomy(
        string $taxonomy,
        array $attributes,
        string $postType = null
    ) {
        if (!Arr::has($attributes, $taxonomy)) {
            return true;
        }

        $postType = $postType ? $postType : $this->type;
        $data = Arr::get($attributes, $taxonomy, []);

        $detachIds = $this->taxonomies()
            ->where('taxonomy', '=', $taxonomy)
            ->whereNotIn('id', $data)
            ->pluck('id')
            ->toArray();

        $this->taxonomies()->detach($detachIds);

        $this->taxonomies()
            ->syncWithoutDetaching(combine_pivot($data, [
                'term_type' => $postType,
            ]), ['term_type' => $postType]);

        $taxonomies = Taxonomy::where('taxonomy', '=', $taxonomy)
            ->whereIn('id', array_merge($detachIds, $data))
            ->get();

        foreach ($taxonomies as $taxonomy) {
            $taxonomy->update([
                'total_post' => $taxonomy->posts()->count(),
            ]);
        }

        return true;
    }

    public function setMeta($key, $value)
    {
        $metas = $this->getMetas();
        $this->metas()->updateOrCreate([
            'meta_key' => $key
        ], [
            'meta_value' => $value
        ]);

        $metas[$key] = $value;

        $this->update([
            'json_metas' => $metas
        ]);
    }

    public function syncMetas(array $data = [])
    {
        $metas = [];
        $keys = $this->getPostTypeMetaKeys();

        foreach ($data as $key => $val) {
            if (!in_array($key, $keys)) {
                continue;
            }

            $this->metas()->updateOrCreate([
                'meta_key' => $key
            ], [
                'meta_value' => is_array($val) ? json_encode($val) : $val
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

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeWherePublish($builder)
    {
        $builder->where('status', '=', 'publish');

        return $builder;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int $taxonomy
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeWhereTaxonomy($builder, $taxonomy)
    {
        $builder->whereHas('taxonomies', function (Builder $q) use ($taxonomy) {
            $q->where($q->getModel()->getTable() . '.id', $taxonomy);
        });

        return $builder;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $taxonomies
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereTaxonomyIn($builder, $taxonomies)
    {
        $builder->whereHas(
            'taxonomies',
            function (Builder $q) use ($taxonomies) {
                $q->whereIn(
                    $q->getModel()->getTable() . '.id',
                    $taxonomies
                );
            }
        );

        return $builder;
    }

    public function getPostType($key = null)
    {
        if ($key == 'key') {
            return $this->type;
        }

        $postType = HookAction::getPostTypes()
            ->where('key', '=', $this->type)
            ->first();

        if (empty($key)) {
            return $postType;
        }

        return $postType->get($key);
    }

    public function getPostTypeMetaKeys()
    {
        return array_keys($this->getPostType('metas'));
    }

    public function getPermalink($key = null)
    {
        $permalink = HookAction::getPermalinks($this->type);

        if (empty($permalink)) {
            return false;
        }

        if (empty($key)) {
            return $permalink;
        }

        return $permalink->get($key);
    }

    public function getTitle($words = null)
    {
        if ($words > 0) {
            return apply_filters(
                $this->type . '.get_title',
                Str::words(
                    $this->{$this->getFieldName()},
                    $words
                ),
                $words
            );
        }

        return apply_filters(
            $this->type . '.get_title',
            $this->{$this->getFieldName()},
            $words
        );
    }

    public function getContent()
    {
        return apply_filters(
            $this->type . '.get_content',
            $this->content
        );
    }

    public function getLink()
    {
        if ($this->type == 'pages') {
            return url()->to($this->slug);
        }

        $permalink = $this->getPermalink('base');
        if (empty($permalink)) {
            return false;
        }

        return url()->to($permalink . '/' . $this->slug);
    }

    public function getUpdatedDate($format = JW_DATE_TIME)
    {
        return jw_date_format($this->updated_at, $format);
    }

    public function getCreatedDate($format = JW_DATE_TIME)
    {
        return jw_date_format($this->updated_at, $format);
    }

    public function getCreatedByName()
    {
        if ($this->createdBy) {
            return $this->createdBy->name;
        }

        return 'Admin';
    }

    public function getCreatedByAvatar()
    {
        if ($this->createdBy) {
            return $this->createdBy->getAvatar();
        }

        return asset('jw-styles/juzaweb/styles/images/avatar.png');
    }

    public function getViews()
    {
        if ($this->views < 1000) {
            return $this->views;
        }

        return round($this->views / 1000, 1) . 'K';
    }

    public function getTotalComments()
    {
        return $this->comments()->whereApproved()->count();
    }
}

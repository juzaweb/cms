<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/8/2021
 * Time: 8:08 PM
 */

namespace Mymo\PostType\Traits;

use Illuminate\Support\Arr;
use Mymo\Core\Traits\ResourceModel;
use Mymo\Core\Traits\UseChangeBy;
use Mymo\Core\Traits\UseSlug;
use Mymo\Core\Traits\UseThumbnail;
use Mymo\PostType\Models\Comment;
use Mymo\PostType\PostType;

/**
 * @method \Illuminate\Database\Eloquent\Builder wherePublish()
 * @method \Illuminate\Database\Eloquent\Builder whereTaxonomy($taxonomy)
 * @method \Illuminate\Database\Eloquent\Builder whereTaxonomyIn($taxonomies)
 * */
trait PostTypeModel
{
    use ResourceModel, UseSlug, UseThumbnail, UseChangeBy;

    public function taxonomies()
    {
        return $this->belongsToMany('Mymo\PostType\Models\Taxonomy', 'term_taxonomies', 'term_id', 'taxonomy_id')
            ->withPivot(['term_type'])
            ->wherePivot('term_type', '=', $this->getPostType());
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')->where('object_type', '=', $this->getPostType());
    }

    public function syncTaxonomies(array $attributes)
    {
        $postType = $this->getPostType();
        $taxonomies = PostType::getTaxonomies($postType);
        foreach ($taxonomies as $taxonomy) {
            if (!Arr::has($attributes, $taxonomy->get('taxonomy'))) {
                continue;
            }

            $this->syncTaxonomy($taxonomy->get('taxonomy'), $attributes, $postType);
        }
    }

    public function syncTaxonomy(string $taxonomy, array $attributes, string $postType = null)
    {
        if (!Arr::has($attributes, $taxonomy)) {
            return;
        }

        $postType = $postType ?? $this->getPostType();
        $data = Arr::get($attributes, $taxonomy, []);
        $detachIds = $this->taxonomies()
            ->where('taxonomy', '=', $taxonomy)
            ->whereNotIn('id', $data)
            ->pluck('id')
            ->toArray();

        $this->taxonomies()->detach($detachIds);
        $this->taxonomies()
            ->syncWithoutDetaching(combine_pivot($data, [
                'term_type' => $postType
            ]), ['term_type' => $postType]);
    }

    public function getStatuses()
    {
        return [
            'draft' => trans('mymo::app.draft'),
            'publish' => trans('mymo::app.publish'),
            'private' => trans('mymo::app.private')
        ];
    }

    public function getPostType()
    {
        if (empty($this->postType)) {
            /*$postType = collect(PostType::getPostTypes())
                ->where('model', static::class)
                ->first();

            return $postType->get('key');*/
            return $this->getTable();
        }

        return $this->postType;
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
        $builder->whereHas('genres', function ($q) use ($taxonomy) {
            $q->where($q->getModel()->getTable() . '.id', $taxonomy);
        });
        return $builder;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $taxonomies
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeWhereTaxonomyIn($builder, $taxonomies)
    {
        $builder->whereHas('genres', function ($q) use ($taxonomies) {
            $q->whereIn($q->getModel()->getTable() . '.id', $taxonomies);
        });
        return $builder;
    }
}
<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Facades\HookAction;

trait TaxonomyModel
{
    use UseSlug;
    use UseThumbnail;
    use ResourceModel;

    public static function bootTaxonomyModel()
    {
        static::saving(function ($model) {
            $model->setAttribute('level', $model->getLevel());
        });
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function posts($postType = null)
    {
        $postType = $postType ? $postType : $this->getPostType('key');
        $postModel = $this->getPostType('model');

        return $this->belongsToMany($postModel, 'term_taxonomies', 'taxonomy_id', 'term_id')
            ->withPivot(['term_type'])
            ->wherePivot('term_type', '=', $postType);
    }

    /**
     * @param Builder $builder
     * @param array $params
     *
     * @return Builder
     */
    public function scopeWhereFilter($builder, $params = [])
    {
        if ($taxonomy = Arr::get($params, 'taxonomy')) {
            $builder->where('taxonomy', '=', $taxonomy);
        }

        if ($postType = Arr::get($params, 'post_type')) {
            $builder->where('post_type', '=', $postType);
        }

        if ($keyword = Arr::get($params, 'keyword')) {
            $builder->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'ilike', '%'. $keyword .'%');
                $q->orWhere('description', 'ilike', '%'. $keyword .'%');
            });
        }

        return $builder;
    }

    public function getPostType($key = null)
    {
        $postType = HookAction::getPostTypes($this->post_type);
        if ($key) {
            return $postType->get($key);
        }

        return $postType;
    }

    public function getPermalink($key = null)
    {
        $permalink = HookAction::getPermalinks($this->taxonomy);

        if (empty($permalink)) {
            return false;
        }

        if (empty($key)) {
            return $permalink;
        }

        return $permalink->get($key);
    }

    public function getLink()
    {
        $permalink = $this->getPermalink('base');
        if (empty($permalink)) {
            return false;
        }

        return url()->to($permalink . '/' . $this->slug);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLevel()
    {
        $level = 0;
        recursive_level_model($level, $this);

        return $level;
    }
}

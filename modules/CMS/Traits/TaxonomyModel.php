<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Facades\HookAction;

trait TaxonomyModel
{
    use UseSlug;
    use UseThumbnail;
    use ResourceModel;

    public static function bootTaxonomyModel(): void
    {
        static::saving(
            function ($model) {
                $model->setAttribute('level', $model->getLevel());
            }
        );
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function recursiveParents(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->parent()->with('recursiveParents');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function recursiveChildren(): HasMany
    {
        return $this->children()->with('recursiveChildren');
    }

    public function posts($postType = null): BelongsToMany
    {
        $postType = $postType ?: $this->getPostType('key');
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
            $builder->where(
                function (Builder $q) use ($keyword) {
                    $q->where('name', JW_SQL_LIKE, '%'. $keyword .'%');
                    $q->orWhere('description', JW_SQL_LIKE, '%'. $keyword .'%');
                }
            );
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

    public function getLevel(): int
    {
        $level = 0;
        recursive_level_model($level, $this);

        return $level;
    }
}

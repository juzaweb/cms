<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\CMS\Traits\Criterias\UseFilterCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSearchCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSortableCriteria;

/**
 * @property Post $model
 */
class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
    use UseSearchCriteria, UseFilterCriteria, UseSortableCriteria;

    protected array $searchableFields = ['title', 'description'];
    protected array $filterableFields = ['status', 'type', 'locale', 'created_by', 'id'];
    protected array $sortableFields = ['id', 'status', 'title', 'views'];
    protected array $sortableDefaults = ['id' => 'DESC'];

    public function findBySlug(string $slug, bool $fail = true): null|Post
    {
        if ($fail) {
            $result = $this->createFrontendDetailBuilder()->where(['slug' => $slug])->firstOrFail();
        } else {
            $result = $this->createFrontendDetailBuilder()->where(['slug' => $slug])->first();
        }

        return $this->parserResult($result);
    }

    public function findByUuid(string $uuid, array $columns = ['*'], bool $fail = true): null|Post
    {
        $this->applyCriteria();
        $this->applyScope();

        if ($fail) {
            $result = $this->model->where(['uuid' => $uuid])->firstOrFail();
        } else {
            $result = $this->model->where(['uuid' => $uuid])->first();
        }

        $this->resetModel();

        return $this->parserResult($result);
    }

    public function frontendListPaginate(int $limit): LengthAwarePaginator
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->createSelectFrontendBuilder()->paginate($limit);

        $this->resetModel();

        return $this->parserResult($result);
    }

    public function frontendListByTaxonomyPaginate(int $limit, int|array $taxonomy, ?int $page = null)
    : LengthAwarePaginator
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->createSelectFrontendBuilder()
            ->when(is_int($taxonomy), fn($q) => $q->whereTaxonomy($taxonomy), fn($q) => $q->whereTaxonomyIn($taxonomy))
            ->paginate($limit, [], 'page', $page);

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($result);
    }

    public function createSelectFrontendBuilder(): Builder|Taxonomy
    {
        $builder = $this->model->newQuery()->with($this->withFrontendDefaults())
            ->cacheFor(3600)
            ->select(
                [
                    'id',
                    'uuid',
                    'title',
                    'description',
                    'thumbnail',
                    'slug',
                    'views',
                    'total_rating',
                    'total_comment',
                    'type',
                    'status',
                    'created_by',
                    'created_at',
                    'json_metas',
                    'json_taxonomies',
                ]
            )
            ->wherePublish();

        return apply_filters('post.selectFrontendBuilder', $builder);
    }

    public function createFrontendDetailBuilder(): Builder
    {
        $with = $this->withFrontendDefaults();
        /*$with['taxonomies'] = function ($q) {
            $q->cacheFor(3600);
            $q->limit(10);
        };*/

        $builder = $this->model->newQuery()->with($with)
            ->cacheFor(config('juzaweb.performance.query_cache.lifetime', 3600))
            ->whereIn('status', [Post::STATUS_PUBLISH, Post::STATUS_PRIVATE]);

        return apply_filters('post.createFrontendDetailBuilder', $builder);
    }

    public function withFrontendDefaults(): array
    {
        return [
            'createdBy' => function ($q) {
                $q->cacheFor(3600);
            },
        ];
    }

    public function getStatuses(string $type = 'posts'): array
    {
        $statuses = [
            Post::STATUS_PUBLISH => trans('cms::app.publish'),
            Post::STATUS_PRIVATE => trans('cms::app.private'),
            Post::STATUS_DRAFT => trans('cms::app.draft'),
            Post::STATUS_TRASH => trans('cms::app.trash'),
        ];

        return apply_filters($type . '.statuses', $statuses);
    }

    public function model(): string
    {
        return Post::class;
    }
}

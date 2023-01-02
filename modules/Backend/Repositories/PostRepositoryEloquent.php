<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * @property Post $model
 */
class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
    protected array $searchableFields = ['title', 'description'];
    
    protected array $filterableFields = ['status'];
    
    public function model(): string
    {
        return Post::class;
    }
    
    public function findBySlug(string $slug): null|Post
    {
        $result = $this->createFrontendDetailBuilder()->where(['slug' => $slug])->firstOrFail();
    
        return $this->parserResult($result);
    }
    
    public function frontendListPaginate(int $limit): LengthAwarePaginator
    {
        $this->applyCriteria();
        $this->applyScope();
        
        $result = $this->createSelectFrontendBuilder()->paginate($limit);
        
        $this->resetModel();
        $this->resetScope();
        
        return $this->parserResult($result);
    }
    
    public function frontendListByTaxonomyPaginate(int $limit, int $taxonomy): LengthAwarePaginator
    {
        $this->applyCriteria();
        $this->applyScope();
        
        $result = $this->createSelectFrontendBuilder()
            ->whereTaxonomy($taxonomy)
            ->paginate($limit);
        
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
                ]
            )
            ->wherePublish();
        
        return apply_filters('post.selectFrontendBuilder', $builder);
    }
    
    public function createFrontendDetailBuilder(): Builder
    {
        $builder = $this->model->newQuery()->with($this->withFrontendDefaults())
            ->cacheFor(3600)
            ->whereIn('status', [Post::STATUS_PUBLISH, Post::STATUS_PRIVATE]);
        
        return apply_filters('post.createFrontendDetailBuilder', $builder);
    }
    
    public function withFrontendDefaults(): array
    {
        return [
            'createdBy' => function ($q) {
                $q->cacheFor(3600);
            },
            'taxonomies' => function ($q) {
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
        
        return apply_filters($type.'.statuses', $statuses);
    }
}

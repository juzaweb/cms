<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
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
    
    public function createSelectFrontendBuilder(): Builder
    {
        $builder = $this->model->newQuery()->with(
            [
                'createdBy' => function ($q) {
                    $q->cacheFor(3600);
                },
                'taxonomies' => function ($q) {
                    $q->cacheFor(3600);
                },
            ]
        )
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
        $builder = $this->model->newQuery()->with(
            [
                'createdBy' => function ($q) {
                    $q->cacheFor(3600);
                },
                'taxonomies' => function ($q) {
                    $q->cacheFor(3600);
                },
            ]
        )
            ->cacheFor(3600)
            ->whereIn('status', [Post::STATUS_PUBLISH, Post::STATUS_PRIVATE]);
        
        return apply_filters('post.createFrontendDetailBuilder', $builder);
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

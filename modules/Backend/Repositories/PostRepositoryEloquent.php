<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
    protected array $searchAble = ['title', 'description'];

    protected array $filterAble = ['status'];

    public function model(): string
    {
        return Post::class;
    }

    public function createSelectFrontendBuilder(): Builder
    {
        $builder = self::with(
            [
                'createdBy',
                'taxonomies',
            ]
        )->select(
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
        )->wherePublish();

        return apply_filters('post.selectFrontendBuilder', $builder);
    }

    public function getStatuses($type = 'posts'): array
    {
        $statuses = [
            Post::STATUS_PUBLISH => trans('cms::app.publish'),
            Post::STATUS_PRIVATE => trans('cms::app.private'),
            Post::STATUS_DRAFT => trans('cms::app.draft'),
            Post::STATUS_TRASH => trans('cms::app.trash'),
        ];

        return apply_filters($type . '.statuses', $statuses);
    }
}

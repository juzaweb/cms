<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
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
}

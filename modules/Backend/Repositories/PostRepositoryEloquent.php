<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class PostRepositoryEloquent extends BaseRepositoryEloquent implements PostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Post::class;
    }
}

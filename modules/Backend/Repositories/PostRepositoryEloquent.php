<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Post;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }
}

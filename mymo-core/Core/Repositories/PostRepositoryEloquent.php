<?php

namespace Mymo\Core\Repositories;

use Mymo\Repository\Eloquent\BaseRepository;
use Mymo\Core\Models\Post;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Mymo\Core\Repositories;
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

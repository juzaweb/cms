<?php

namespace Mymo\PostType\Repositories;

use Mymo\PostType\PostType;
use Mymo\Repository\Eloquent\BaseRepository;
use Mymo\PostType\Models\Post;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Mymo\PostType\Repositories;
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

    public function getSetting()
    {
        return PostType::getPostTypes('posts');
    }
}

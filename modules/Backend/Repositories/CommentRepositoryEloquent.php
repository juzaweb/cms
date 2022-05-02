<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Comment;
use Juzaweb\CMS\Repositories\BaseRepository;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }
}

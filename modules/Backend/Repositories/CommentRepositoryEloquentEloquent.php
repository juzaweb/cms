<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Comment;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class CommentRepositoryEloquentEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class CommentRepositoryEloquentEloquent extends BaseRepositoryEloquent implements CommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Comment::class;
    }
}

<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Resource;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class ResourceRepositoryEloquent extends BaseRepositoryEloquent implements ResourceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Resource::class;
    }
}

<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\MediaFolder;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class MediaFolderRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class MediaFolderRepositoryEloquent extends BaseRepositoryEloquent implements MediaFolderRepository
{
    public function model(): string
    {
        return MediaFolder::class;
    }
}

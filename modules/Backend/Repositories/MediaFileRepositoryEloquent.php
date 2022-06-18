<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class MediaFileRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class MediaFileRepositoryEloquent extends BaseRepositoryEloquent implements MediaFileRepository
{
    public function model(): string
    {
        return MediaFile::class;
    }
}

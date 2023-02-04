<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\CMS\Traits\Criterias\UseFilterCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSearchCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSortableCriteria;

/**
 * Class MediaFileRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class MediaFileRepositoryEloquent extends BaseRepositoryEloquent implements MediaFileRepository
{
    use UseSortableCriteria, UseFilterCriteria, UseSearchCriteria;
    
    protected array $searchableFields = ['name'];
    protected array $filterableFields = ['folder_id', 'type'];
    protected array $sortableFields = ['id', 'size'];
    protected array $sortableDefaults = ['id' => 'DESC'];
    
    public function model(): string
    {
        return MediaFile::class;
    }
}

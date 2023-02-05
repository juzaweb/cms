<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\MediaFolder;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\CMS\Traits\Criterias\UseFilterCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSearchCriteria;
use Juzaweb\CMS\Traits\Criterias\UseSortableCriteria;

/**
 * Class MediaFolderRepositoryEloquent.
 *
 * @property MediaFolder $model
 */
class MediaFolderRepositoryEloquent extends BaseRepositoryEloquent implements MediaFolderRepository
{
    use UseSortableCriteria, UseFilterCriteria, UseSearchCriteria;
    
    protected array $searchableFields = ['name'];
    protected array $filterableFields = ['folder_id', 'type'];
    protected array $sortableFields = ['id'];
    protected array $sortableDefaults = ['id' => 'DESC'];
    
    public function model(): string
    {
        return MediaFolder::class;
    }
}

<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class TaxonomyRepositoryEloquentEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class TaxonomyRepositoryEloquent extends BaseRepositoryEloquent implements TaxonomyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Taxonomy::class;
    }
}

<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * @property Taxonomy $model
 */
class TaxonomyRepositoryEloquent extends BaseRepositoryEloquent implements TaxonomyRepository
{
    public function model(): string
    {
        return Taxonomy::class;
    }
}

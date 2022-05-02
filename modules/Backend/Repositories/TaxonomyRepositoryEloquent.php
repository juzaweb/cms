<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Repositories\BaseRepository;

/**
 * Class TaxonomyRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class TaxonomyRepositoryEloquent extends BaseRepository implements TaxonomyRepository
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

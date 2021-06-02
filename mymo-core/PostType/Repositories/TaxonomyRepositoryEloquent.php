<?php

namespace Mymo\PostType\Repositories;

use Mymo\PostType\PostType;
use Mymo\Repository\Eloquent\BaseRepository;
use Mymo\PostType\Models\Taxonomy;

class TaxonomyRepositoryEloquent extends BaseRepository implements TaxonomyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Taxonomy::class;
    }


}

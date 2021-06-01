<?php

namespace Mymo\Core\Repositories;

use Mymo\PostType\PostType;
use Mymo\Repository\Eloquent\BaseRepository;
use Mymo\Core\Models\Taxonomy;

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

    public function getSetting()
    {
        return PostType::getSetting('posts');
    }
}

<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\CMS\Repositories\BaseRepository;

interface TaxonomyRepository extends BaseRepository
{
    public function frontendListPaginate(int $limit);
    
    public function frontendDetail(string $slug);
}

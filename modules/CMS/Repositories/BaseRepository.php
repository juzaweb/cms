<?php

namespace Juzaweb\CMS\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\CMS\Repositories\Contracts\RepositoryCriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

/**
 * Interface BaseRepository.
 *
 * @method Builder query()
 * @package namespace Juzaweb\Backend\Repositories;
 */
interface BaseRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * @return Builder
     */
    public function getQuery(): Builder;

    public function resetModel();
}

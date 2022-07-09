<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\CMS\Repositories\BaseRepository;

/**
 * Interface PostRepository.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
interface PostRepository extends BaseRepository
{
    public function createSelectFrontendBuilder(): Builder;
}

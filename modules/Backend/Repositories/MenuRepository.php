<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\Backend\Models\Menu;
use Juzaweb\CMS\Repositories\BaseRepository;

/**
 * Interface CommentRepository.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
interface MenuRepository extends BaseRepository
{
    public function getFrontendDetail(int $menu): Menu;

    public function getFrontendDetailByLocation(string $location): ?Menu;
}

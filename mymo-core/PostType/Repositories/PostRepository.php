<?php

namespace Mymo\PostType\Repositories;

use Mymo\Repository\Contracts\RepositoryInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace Mymo\Core\Repositories;
 */
interface PostRepository extends RepositoryInterface
{
    public function getSetting();
}

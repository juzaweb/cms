<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Repositories\BaseRepository;

/**
 * Interface PostRepository.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
interface PostRepository extends BaseRepository
{
    public function create(array $attributes);

    public function update(array $attributes, $id);

    public function createSelectFrontendBuilder(): Builder;
    
    public function createFrontendDetailBuilder(): Builder;
    
    public function getStatuses(string $type = 'posts'): array;
}

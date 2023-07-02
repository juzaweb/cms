<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Repositories\BaseRepository;
use Juzaweb\CMS\Repositories\Exceptions\RepositoryException;
use Juzaweb\CMS\Repositories\Interfaces\FilterableInterface;
use Juzaweb\CMS\Repositories\Interfaces\SearchableInterface;
use Juzaweb\CMS\Repositories\Interfaces\SortableInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
interface PostRepository extends BaseRepository, FilterableInterface, SearchableInterface, SortableInterface
{
    /**
     * @param array $attributes
     * @return Post
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @param $id
     * @return Post
     */
    public function update(array $attributes, $id);

    /**
     * @param string $slug
     * @param bool $fail
     * @return Post|null
     */
    public function findBySlug(string $slug, bool $fail = true): null|Post;

    /**
     * @param string $uuid
     * @param array $columns
     * @param bool $fail
     * @return Post|null
     */
    public function findByUuid(string $uuid, array $columns = ['*'], bool $fail = true): null|Post;

    /**
     * @param int $limit
     * @param int $taxonomy
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function frontendListByTaxonomyPaginate(int $limit, int $taxonomy, ?int $page = null): LengthAwarePaginator;

    /**
     * @param int $limit
     * @return LengthAwarePaginator
     * @throws RepositoryException
     */
    public function frontendListPaginate(int $limit): LengthAwarePaginator;

    /**
     * @return Builder|Taxonomy
     */
    public function createSelectFrontendBuilder(): Builder|Taxonomy;

    /**
     * @return Builder
     */
    public function createFrontendDetailBuilder(): Builder;

    /**
     * @param string $type
     * @return array
     */
    public function getStatuses(string $type = 'posts'): array;
}

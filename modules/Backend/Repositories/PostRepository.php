<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @method Post find($id, $columns = ['*'])
 * @method Post create(array $attributes)
 * @method Post update(array $attributes, int|string $id)
 * @package namespace Juzaweb\Backend\Repositories;
 * @see PostRepositoryEloquent
 */
interface PostRepository extends BaseRepository, FilterableInterface, SearchableInterface, SortableInterface
{
    public function frontendFind(int|string $id, array $columns = ['*']): ?Post;

    /**
     * @param  string  $slug
     * @param  bool  $fail
     * @param  array  $columns
     * @return Post|null
     * @see PostRepositoryEloquent::findBySlug()
     */
    public function findBySlug(string $slug, bool $fail = true, array $columns = ['*']): null|Post;

    /**
     * @param  string  $uuid
     * @param  array  $columns
     * @param  bool  $fail
     * @return Post|null
     */
    public function findByUuid(string $uuid, array $columns = ['*'], bool $fail = true): null|Post;

    /**
     * @param  int  $limit
     * @param  int  $taxonomy
     * @param  int|null  $page
     * @return LengthAwarePaginator
     * @see PostRepositoryEloquent::frontendListByTaxonomyPaginate()
     */
    public function frontendListByTaxonomyPaginate(int $limit, int $taxonomy, ?int $page = null): LengthAwarePaginator;

    /**
     * @param  int  $limit
     * @param  array  $columns
     * @return LengthAwarePaginator
     * @throws RepositoryException
     * @see PostRepositoryEloquent::frontendListPaginate()
     */
    public function frontendListPaginate(int $limit, array $columns = ['*']): LengthAwarePaginator;

    /**
     * @return Builder|Taxonomy
     * @see PostRepositoryEloquent::createSelectFrontendBuilder()
     */
    public function createSelectFrontendBuilder(): Builder|Taxonomy;

    /**
     * @return Builder
     * @see PostRepositoryEloquent::createSelectFrontendBuilder()
     */
    public function createFrontendDetailBuilder(): Builder;

    /**
     * @param  Post  $post
     * @param  string  $taxonomy
     * @param  int  $limit
     * @param  array  $columns
     * @return Collection|array
     * @see PostRepositoryEloquent::getRelatedPosts()
     */
    public function getRelatedPosts(
        Post $post,
        string $taxonomy = 'categories',
        int $limit = 10,
        array $columns = ['*']
    ): Collection|array;

    /**
     * @param  string  $type
     * @return array
     */
    public function getStatuses(string $type = 'posts'): array;
}

<?php

namespace Juzaweb\Backend\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Models\User;
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
    /**
     * Find a post in the frontend by ID.
     *
     * @param int|string $id The ID of the post.
     * @param array $columns The columns to retrieve from the post. Default is all columns.
     * @return Post|null The found post, or null if not found.
     * @see PostRepositoryEloquent::frontendFind()
     */
    public function frontendFind(int|string $id, array $columns = ['*']): ?Post;

    /**
     * Find a post by its slug.
     *
     * @param string $slug The slug of the post to find.
     * @param bool $fail Whether to throw an exception if no post is found. Default is true.
     * @param array $columns The columns to retrieve from the post. Default is ['*'].
     * @param bool $frontend Whether the search is performed in the frontend. Default is true.
     * @return Post|null The found post object or null if no post is found.
     * @see PostRepositoryEloquent::findBySlug()
     */
    public function findBySlug(string $slug, bool $fail = true, array $columns = ['*'], bool $frontend = true): ?Post;

    /**
     * Find a post by its slug in the frontend.
     *
     * @param string $slug The slug of the post to find.
     * @param bool $fail Whether to throw an exception if the post is not found (default: true).
     * @param array $columns The columns to retrieve from the database (default: ['*']).
     * @return null|Post The found post, or null if $fail is false and the post is not found.
     * @see PostRepositoryEloquent::findBySlug()
     */
    public function frontendFindBySlug(string $slug, bool $fail = true, array $columns = ['*']): null|Post;

    /**
     * Find a post by UUID.
     *
     * @param string $uuid The UUID of the post.
     * @param array $columns The columns to select from the post (default: ['*']).
     * @param bool $fail Whether to throw an exception if the post is not found (default: true).
     * @return null|Post The found post, or null if not found and $fail is false.
     * @see PostRepositoryEloquent::findByUuid()
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
     * Creates a new instance of the SelectFrontendBuilder.
     *
     * @return Builder|Taxonomy The SelectFrontendBuilder instance.
     * @see PostRepositoryEloquent::createSelectFrontendBuilder()
     */
    public function createSelectFrontendBuilder(): Builder|Taxonomy;

    /**
     * Creates a frontend detail builder.
     *
     * @return Builder The frontend detail builder.
     * @see PostRepositoryEloquent::createSelectFrontendBuilder()
     */
    public function createFrontendDetailBuilder(): Builder;

    /**
     * Retrieves related posts based on the given post, taxonomy, limit, and columns.
     *
     * @param Post $post The post to retrieve related posts for.
     * @param string $taxonomy The taxonomy to filter related posts by. Defaults to 'categories'.
     * @param int $limit The maximum number of related posts to retrieve. Defaults to 10.
     * @param array $columns The columns to retrieve from the related posts. Defaults to ['*'].
     * @return Collection|array The collection or array of related posts.
     * @see PostRepositoryEloquent::getRelatedPosts()
     */
    public function getRelatedPosts(
        Post $post,
        string $taxonomy = 'categories',
        int $limit = 10,
        array $columns = ['*']
    ): Collection|array;

    public function getLikedPosts(User $user, int $limit = 10, array $columns = ['*']): LengthAwarePaginator|array;

    /**
     * Retrieves the statuses for a given type.
     *
     * @param string $type The type of statuses to retrieve. Defaults to 'posts'.
     * @return array The array of statuses.
     */
    public function getStatuses(string $type = 'posts'): array;
}

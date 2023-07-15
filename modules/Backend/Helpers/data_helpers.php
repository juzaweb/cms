<?php

use Illuminate\Support\Arr;
use Juzaweb\Backend\Http\Resources\ResourceResource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\CMS\Facades\JWQuery;
use Juzaweb\CMS\Facades\Theme;

function get_posts(string $type = null, array $options = []): array
{
    return JWQuery::posts($type, $options);
}

function get_posts_by_filter(?array $options): ?array
{
    if ($sortBy = Arr::get($options, 'sort_by')) {
        $options['order_by'] = [$sortBy => Arr::get($options, 'sort_order', 'asc')];
    }

    return JWQuery::posts($options['type'] ?? 'posts', $options);
}

function get_post_taxonomy($post, $taxonomy = null, $params = []): ?array
{
    return JWQuery::postTaxonomy($post, $taxonomy, $params);
}

function get_post_taxonomies($post, $taxonomy = null, $params = []): ?array
{
    return JWQuery::postTaxonomies($post, $taxonomy, $params);
}

function get_related_posts($post, $limit = 5, $taxonomy = null): ?array
{
    return JWQuery::relatedPosts($post, $limit, $taxonomy);
}

/**
 * Get the most popular posts.
 *
 *
 * @param  string|null  $type The type of post to retrieve.
 * @param  array|null  $post An optional post array to exclude from the results.
 * @param  int  $limit The maximum number of posts to return. Defaults to 5.
 * @param  array  $options Optional options for retrieving posts.
 *
 * @return array An array of the most popular posts.
 */
function get_popular_posts(string $type = null, array $post = null, int $limit = 5, array $options = []): array
{
    if ($limit > 20) {
        $limit = 20;
    }

    $query = Post::selectFrontendBuilder();

    if ($post) {
        $query->where('id', '!=', Arr::get($post, 'id'));
    }

    if ($type) {
        $query->where('type', '=', $type);
    }

    $query->orderBy('views', 'DESC');

    $posts = $query->take($limit)->get();

    return Theme::parseParam($posts);
}

/**
 * Retrieve post resources from database.
 *
 * @param string $resource Resource type to query.
 * @param array $options Options for sorting, limiting, and paginating the query.
 * - id: Resource id.
 * - post_id: Post id.
 * - parent_id: Parent resource id.
 * - order_by: Array containing column name and direction to sort by.
 * - paginate: Number of records to paginate.
 * - limit: Limit records returned in the query.
 *
 * @return array Collection of post resources.
 */
function get_post_resources(string $resource, array $options = []): array
{
    $query = Resource::selectFrontendBuilder()->where('type', '=', $resource);

    if ($id = Arr::get($options, 'id')) {
        $query->where('id', '=', $id);
    }

    if ($postId = Arr::get($options, 'post_id')) {
        $query->where('post_id', '=', $postId);
    }

    if ($parentId = Arr::get($options, 'parent_id')) {
        $query->where('parent_id', '=', $parentId);
    }

    if ($orderBys = Arr::get($options, 'order_by')) {
        foreach ($orderBys as $column => $direction) {
            $query->orderBy($column, $direction);
        }
    }

    if ($paginate = Arr::get($options, 'paginate')) {
        if ($paginate > 100) {
            $paginate = 10;
        }

        $data = $query->paginate($paginate);
    } else {
        $limit = Arr::get($options, 'limit', 10);
        if ($limit > 100) {
            $limit = 10;
        }

        $data = $query->limit($limit)->get();
    }

    return ResourceResource::collection($data)->toArray(request());
}

/**
 * Get a single post resource.
 *
 * @param string $resource The name of the resource to get.
 * @param int $id The id of the post to get.
 *
 * @return array|null An array of the resource data, or null if not found.
 */
function get_post_resource(string $resource, int $id): ?array
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $resource)
        ->where('id', '=', $id);
    $data = $query->first();
    return $data ? (new ResourceResource($data))->toArray(request()) : null;
}

/**
 * Return the next resource of a given type.
 *
 * @param string $type The type of resource to get next.
 * @param array|null $resource The current resource which may be used to get the next one.
 *
 * @return array|null The next resource or null if none exists.
 */
function get_next_resource(string $type, ?array $resource): ?array
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $type)
        ->where('id', '>', Arr::get($resource, 'id'));
    $data = $query->first();
    return $data ? (new ResourceResource($data))->toArray(request()) : null;
}

if (!function_exists('get_previous_post')) {
    /**
     * Retrieves the previous post from the database in relation to the current post.
     *
     * @param  array|Post|null  $currentPost  The current Post array for comparison.
     *
     * @return array|Post|null The previous Post as an array or null if not found.
     */
    function get_previous_post(array|null|Post $currentPost): array|null|Post
    {
        if (empty($post)) {
            return [];
        }

        if (is_array($currentPost)) {
            $postId = Arr::get($currentPost, 'id');
        } else {
            $postId = $currentPost->id;
        }

        $post = Post::selectFrontendBuilder()
            ->where('id', '<', $postId)
            ->orderBy('id', 'DESC')
            ->first();

        return Theme::parseParam($post);
    }
}

if (!function_exists('get_next_post')) {
    /**
     * Get the next post from the database by ID.
     *
     * @param  array|null  $post  The post object.
     *
     * @return array|Post|null An array containing the details of the next post, if one exists. Otherwise, null.
     */
    function get_next_post(null|array $post): mixed
    {
        $post = Post::selectFrontendBuilder()
            ->where('id', '>', Arr::get($post, 'id', 0))
            ->orderBy('id', 'ASC')
            ->first();

        if (empty($post)) {
            return null;
        }

        return Theme::parseParam($post);
    }
}

/**
 * Get taxonomy
 *
* @param $taxonomy
* @param $args
* @return array|Post|null
 */
function get_taxonomy($taxonomy, $args = []): mixed
{
    if (empty($taxonomy)) {
        return [];
    }

    return Theme::parseParam(Taxonomy::find($taxonomy));
}

function get_taxonomies($args = []): array
{
    $query = Taxonomy::selectFrontendBuilder();
    $type = Arr::get($args, 'type');
    $taxonomy = Arr::get($args, 'taxonomy');
    $inIds = Arr::get($args, 'id_in');
    $limit = Arr::get($args, 'limit', 10);

    if ($limit > 100) {
        $limit = 10;
    }

    if ($type) {
        $query->where('post_type', '=', $type);
    }

    if ($taxonomy) {
        $query->where('taxonomy', '=', $taxonomy);
    }

    if ($parentId = Arr::get($args, 'parent_id')) {
        $query->where('parent_id', $parentId);
    }

    if ($inIds) {
        if (!is_array($inIds)) {
            $inIds = [$inIds];
        }

        $query->whereIn('id', $inIds);
    }

    $taxonomies = $query->limit($limit)->get();

    return Theme::parseParam($taxonomies);
}

function get_total_resource($resource, $args = []): int
{
    $query = Resource::selectFrontendBuilder()->where('type', '=', $resource);

    if ($postId = Arr::get($args, 'post_id')) {
        $query->where('post_id', $postId);
    }

    return $query->count();
}

function get_page_url(string|int|Post|null $page): null|string
{
    if (empty($page)) {
        return null;
    }

    if ($page instanceof Post) {
        return $page->getLink();
    }

    if (is_numeric($page)) {
        $data = Post::cacheFor(3600)->find($page, ['id', 'slug', 'type']);

        if ($data) {
            return $data->getLink();
        }
    }

    $data = Post::cacheFor(3600)
        ->where('slug', '=', $page)
        ->first(['id', 'slug', 'type']);

    return $data?->getLink();
}

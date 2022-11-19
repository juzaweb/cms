<?php

use Illuminate\Support\Arr;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Http\Resources\ResourceResource;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\CMS\Facades\JWQuery;

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

function get_post_taxonomies($post, $taxonomy = null, $params = [])
{
    return JWQuery::postTaxonomies($post, $taxonomy, $params);
}

function get_related_posts($post, $limit = 5, $taxonomy = null): ?array
{
    return JWQuery::relatedPosts($post, $limit, $taxonomy);
}

function get_popular_posts($type = null, $post = null, $limit = 5, $options = []): array
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

    return PostResourceCollection::make($posts)->toArray(request());
}

function get_post_resources($resource, $options = []): array
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $resource);

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

function get_post_resource($resource, $id): ?array
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $resource)
        ->where('id', '=', $id);
    $data = $query->first();
    return $data ? (new ResourceResource($data))->toArray(request()) : null;
}

function get_next_resource(string $type, ?array $resource): ?array
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $type)
        ->where('id', '>', Arr::get($resource, 'id'));
    $data = $query->first();
    return $data ? (new ResourceResource($data))->toArray(request()) : null;
}

function get_previous_post(?array $currentPost): ?array
{
    $post = Post::selectFrontendBuilder()
        ->where('id', '<', Arr::get($currentPost, 'id'))
        ->orderBy('id', 'DESC')
        ->first();

    return $post ? (new PostResource($post))->toArray(request()) : null;
}

function get_next_post($post): ?array
{
    $post = Post::selectFrontendBuilder()
        ->where('id', '>', Arr::get($post, 'id', 0))
        ->orderBy('id', 'ASC')
        ->first();

    if (empty($post)) {
        return null;
    }

    return (new PostResource($post))->toArray(request());
}

function get_taxonomy($taxonomy, $args = []): array
{
    if (empty($taxonomy)) {
        return [];
    }

    $tax = Taxonomy::find($taxonomy);
    return (new TaxonomyResource($tax))
        ->toArray(request());
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

    $data = $query->limit($limit)->get();

    return TaxonomyResource::collection($data)
        ->toArray(request());
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

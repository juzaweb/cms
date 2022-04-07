<?php

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Http\Resources\ResourceResource;
use Juzaweb\Backend\Http\Resources\TaxonomyResource;
use Juzaweb\Backend\Models\Taxonomy;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Resource;

function get_posts($type, $options = [])
{
    $paginate = Arr::get($options, 'paginate');
    $taxonomies = Arr::get($options, 'taxonomies');
    $taxonomy = Arr::get($options, 'taxonomy');
    $limit = Arr::get($options, 'limit');
    $metas = Arr::get($options, 'metas');
    $orderBy = Arr::get($options, 'order_by');

    if ($paginate && $paginate > 30) {
        $paginate = 12;
    }

    $query = Post::selectFrontendBuilder()
        ->where('type', '=', $type);

    if ($taxonomies) {
        $query->whereTaxonomyIn($taxonomies);
    }

    if ($taxonomy) {
        $query->whereTaxonomy($taxonomy);
    }

    if ($metas && is_array($metas)) {
        foreach ($metas as $key => $meta) {
            if (is_numeric($key) || empty($key)) {
                continue;
            }

            $query->whereMeta($key, $meta);
        }
    }

    if (empty($orderBy)) {
        $orderBy = ['id' => 'DESC'];
    }

    foreach ($orderBy as $col => $val) {
        if (!in_array($col, ['id', 'views'])) {
            continue;
        }

        if (!in_array(strtoupper($val), ['DESC', 'ASC'])) {
            continue;
        }

        $query->orderBy($col, $val);
    }

    if ($limit) {
        if ($limit > 50) {
            $limit = 10;
        }

        $query->limit($limit);
    }

    if ($paginate) {
        $posts = $query->paginate($paginate);

        return PostResource::collection($posts)
            ->response()
            ->getData(true);
    }

    $posts = $query->get();

    return PostResource::collection($posts)
        ->toArray(request());
}

function get_post_taxonomy($post, $taxonomy = null, $params = [])
{
    $taxonomies = collect($post['taxonomies'] ?? []);

    if ($taxonomy) {
        $taxonomies = $taxonomies->where('taxonomy', $taxonomy);
    }

    if (Arr::get($params, 'tree')) {
        $taxonomies = $taxonomies->sortBy('level');
    }

    $taxonomy = $taxonomies->first();

    if ($taxonomy) {
        return $taxonomy;
    }

    return $taxonomy;
}

function get_post_taxonomies($post, $taxonomy = null, $params = [])
{
    $taxonomies = collect($post['taxonomies']);

    if ($taxonomy) {
        $taxonomies = $taxonomies->where('taxonomy', $taxonomy);
    }

    if ($parentId = Arr::get($params, 'parent_id')) {
        $taxonomies = $taxonomies->where('parent_id', $parentId);
    }

    if (Arr::get($params, 'tree')) {
        $taxonomies = $taxonomies->sortBy('level');
    }

    if ($limit = Arr::get($params, 'limit')) {
        $taxonomies = $taxonomies->take($limit);
    }

    return $taxonomies->toArray();
}

function get_related_posts($post, $limit = 5, $taxonomy = null)
{
    if ($limit > 20) {
        $limit = 20;
    }

    $ids = collect(get_post_taxonomies($post, $taxonomy))
        ->pluck('id')
        ->toArray();

    $posts = Post::selectFrontendBuilder()
        ->whereHas('taxonomies', function (Builder $q) use ($ids) {
            $q->whereIn("{$q->getModel()->getTable()}.id", $ids);
        })
        ->where('id', '!=', $post['id'])
        ->orderBy('id', 'DESC')
        ->take($limit)
        ->get();

    return PostResource::collection($posts)
        ->toArray(request());
}

function get_popular_posts($type = null, $post = null, $limit = 5, $options = [])
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

    return PostResource::collection($posts)
        ->toArray(request());
}

function get_post_resources($resource, $options = [])
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

    $limit = Arr::get($options, 'limit', 10);
    if ($limit > 100) {
        $limit = 10;
    }

    $data = $query
        ->orderBy('display_order', 'ASC')
        ->limit($limit)
        ->get();

    return ResourceResource::collection($data)
        ->toArray(request());
}

function get_post_resource($resource, $id)
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $resource)
        ->where('id', '=', $id);
    $data = $query->first();

    if (empty($data)) {
        return $data;
    }

    return (new ResourceResource($data))->toArray(request());
}

function get_previous_post($post)
{
    $post = Post::selectFrontendBuilder()
        ->where('id', '<', Arr::get($post, 'id', 0))
        ->orderBy('id', 'DESC')
        ->first();

    if (empty($post)) {
        return null;
    }

    return (new PostResource($post))->toArray(request());
}

function get_next_post($post)
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

function get_taxonomy($taxonomy, $args = [])
{
    if (empty($taxonomy)) {
        return [];
    }

    $tax = Taxonomy::find($taxonomy);
    return (new TaxonomyResource($tax))
        ->toArray(request());
}

function get_taxonomies($args = [])
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

function get_total_resource($resource, $args = [])
{
    $query = Resource::selectFrontendBuilder()
        ->where('type', '=', $resource);

    if ($postId = Arr::get($args, 'post_id')) {
        $query->where('post_id', $postId);
    }

    return $query->count();
}

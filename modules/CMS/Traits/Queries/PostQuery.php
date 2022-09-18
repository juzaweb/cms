<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Traits\Queries;

use Illuminate\Support\Arr;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;

trait PostQuery
{
    public function posts(string $type = null, array $options = []): array
    {
        $taxonomies = Arr::get($options, 'taxonomies');
        $taxonomy = Arr::get($options, 'taxonomy');
        $hasThumbnail = filter_var(
            Arr::get($options, 'has_thumbnail', false),
            FILTER_VALIDATE_BOOLEAN
        );

        $limit = Arr::get($options, 'limit');
        $paginate = Arr::get($options, 'paginate');
        $metas = Arr::get($options, 'metas');
        $orderBy = Arr::get($options, 'order_by');

        if ($paginate && $paginate > 30) {
            $paginate = 12;
        }

        $query = Post::selectFrontendBuilder();

        if ($type) {
            $query->where('type', '=', $type);
        }

        if ($hasThumbnail) {
            $query->whereNotNull('thumbnail');
        }

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

        if ($paginate) {
            $posts = $query->paginate($paginate);

            $posts->appends(request()->query());

            return PostResource::collection($posts)
                ->response()
                ->getData(true);
        }

        if (empty($limit) || $limit > 50) {
            $limit = 10;
        }

        $query->limit($limit);

        $posts = $query->get();

        return PostResource::collection($posts)
            ->toArray(request());
    }

    public function postTaxonomy(
        array $post,
        string $taxonomy = null,
        array $params = []
    ): mixed {
        $taxonomies = collect($post['taxonomies'] ?? []);

        if ($taxonomy) {
            $taxonomies = $taxonomies->where('taxonomy', $taxonomy);
        }

        if (Arr::get($params, 'tree')) {
            $taxonomies = $taxonomies->sortBy('level');
        }

        return $taxonomies->first();
    }

    public function postTaxonomies(
        array $post,
        string $taxonomy = null,
        array $params = []
    ): array {
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
}

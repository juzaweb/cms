<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Http\Controllers\Abstracts;

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Http\Controllers\Controller;

abstract class BaseSitemapController extends Controller
{
    protected int $perPage = 500;
    protected int $limitTaxonomyPage = 10;
    protected int $limitPostPage = 200;

    public function __construct()
    {
        if (!get_config('jw_enable_sitemap', true)) {
            abort(404);
        }
    }

    protected function totalPost(string $type): int
    {
        return Cache::store('file')->remember(
            cache_prefix("sitemap_post_total_{$type}"),
            3600,
            fn() => Post::wherePublish()
                ->where('type', '=', $type)
                ->count(['id'])
        );
    }

    protected function totalTaxonomy(string $taxonomy): int
    {
        return Cache::store('file')->remember(
            cache_prefix("sitemap_taxonomy_total_{$taxonomy}"),
            3600,
            fn() => Taxonomy::where('taxonomy', '=', $taxonomy)
                ->where('total_post', '>', 0)
                ->count(['id'])
        );
    }
}

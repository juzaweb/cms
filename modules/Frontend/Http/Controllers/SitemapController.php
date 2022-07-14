<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Facades\App;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\Controller;

class SitemapController extends Controller
{
    protected int $per_page = 500;

    public function __construct()
    {
        if (!get_config('jw_enable_sitemap', true)) {
            abort(404);
        }
    }

    public function index()
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap-index"), 3600);

        $taxonomies = HookAction::getTaxonomies()
            ->mapWithKeys(
                function ($item, $key) {
                    return array_keys($item);
                }
            )
            ->unique()
            ->values();

        $types = HookAction::getPostTypes();

        $sitemap->addSitemap(route('sitemap.pages'));

        foreach ($taxonomies as $taxonomy) {
            $items = Taxonomy::where('taxonomy', '=', $taxonomy)
                ->count(['id']);

            $total = ceil($items / $this->per_page);

            for ($page = 1; $page <= $total; $page++) {
                $sitemap->addSitemap(route('sitemap.taxonomies', [$taxonomy, $page]));
            }
        }

        foreach ($types as $key => $type) {
            $items = Post::wherePublish()
                ->where('type', '=', $key)
                ->count(['id']);

            $total = ceil($items / $this->per_page);

            for ($page = 1; $page <= $total; $page++) {
                $sitemap->addSitemap(route('sitemap.posts', [$key, $page]));
            }
        }

        return $sitemap->render('sitemapindex');
    }

    public function pages()
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap"), 3600);
        $sitemap->add(url('/'), now(), '1', 'daily');
        return $sitemap->render('xml');
    }

    public function sitemapPost($type, $page)
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap-{$type}"), 3600);
        $items = Post::wherePublish()
            ->where('type', '=', $type)
            ->orderBy('id', 'DESC')
            ->paginate(
                $this->per_page,
                ['updated_at', 'slug', 'type'],
                'page',
                $page
            );

        foreach ($items as $item) {
            $sitemap->add($item->getLink(), $item->updated_at, '0.8', 'daily');
        }

        return $sitemap->render('xml');
    }

    public function sitemapTaxonomy($taxonomy, $page)
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap-taxonomy-{$taxonomy}"), 3600);
        $items = Taxonomy::where('taxonomy', '=', $taxonomy)
            ->paginate(
                $this->per_page,
                ['updated_at', 'slug', 'taxonomy', 'post_type'],
                'page',
                $page
            );

        foreach ($items as $item) {
            $sitemap->add($item->getLink(), $item->updated_at, '0.8', 'weekly');
        }

        return $sitemap->render('xml');
    }
}

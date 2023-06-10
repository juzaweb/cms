<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\Frontend\Http\Controllers\Abstracts\BaseSitemapController;

class SitemapController extends BaseSitemapController
{
    public function index()
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap-index"), 3600);

        $taxonomies = HookAction::getTaxonomies()
            ->mapWithKeys(fn($item) => array_keys($item))
            ->unique()
            ->values();

        $types = HookAction::getPostTypes();
        $sitemap->addSitemap(route('sitemap.pages'));

        foreach ($taxonomies as $taxonomy) {
            $items = $this->totalTaxonomy($taxonomy);

            $total = ceil($items / $this->perPage);
            if ($total > $this->limitTaxonomyPage) {
                $total = $this->limitTaxonomyPage;
            }

            for ($page = 1; $page <= $total; $page++) {
                $sitemap->addSitemap(route('sitemap.taxonomies', [$taxonomy, $page]));
            }
        }

        foreach ($types as $key => $type) {
            $items = $this->totalPost($key);
            $total = ceil($items / $this->perPage);

            if ($total > $this->limitPostPage) {
                $total = $this->limitPostPage;
            }

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
        $sitemap->setCache(cache_prefix("sitemap-{$type}-{$page}"), 3600);
        $items = Cache::store('file')->remember(
            "sitemap_post_{$type}_{$page}",
            3600,
            fn() => Post::wherePublish()
                ->where('type', '=', $type)
                ->orderBy('id', 'DESC')
                ->paginate(
                    $this->perPage,
                    ['updated_at', 'slug', 'type'],
                    'page',
                    $page
                )
        );

        foreach ($items as $item) {
            $sitemap->add($item->getLink(), $item->updated_at, '0.8', 'daily');
        }

        return $sitemap->render('xml');
    }

    public function sitemapTaxonomy($taxonomy, $page)
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap-taxonomy-{$taxonomy}-{$page}"), 3600);
        $items = Cache::store('file')->remember(
            "sitemap_post_{$taxonomy}_{$page}",
            3600,
            fn() => Taxonomy::where('taxonomy', '=', $taxonomy)
                ->where('total_post', '>', 0)
                ->paginate(
                    $this->perPage,
                    ['updated_at', 'slug', 'taxonomy', 'post_type'],
                    'page',
                    $page
                )
            );

        foreach ($items as $item) {
            $sitemap->add($item->getLink(), $item->updated_at, '0.8', 'weekly');
        }

        return $sitemap->render('xml');
    }
}

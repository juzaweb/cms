<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Facades\App;
use Juzaweb\Frontend\Http\Controllers\Abstracts\BaseSitemapController;

class PostSitemapController extends BaseSitemapController
{
    public function index(string $type, int $page)
    {
        $sitemap = App::make("sitemap");
        $sitemap->setCache(cache_prefix("sitemap-post-index"), 3600);

        $items = $this->totalPost($type);
        $total = ceil($items / $this->perPage);

        $startPage = ($this->limitPostPage * ($page - 1)) + 1;
        if ($total > $this->limitPostPage * $page) {
            $total = $this->limitPostPage * $page;
        }

        for ($i = $startPage; $i <= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.posts', [$type, $i]));
        }

        return $sitemap->render('sitemapindex');
    }
}

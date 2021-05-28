<?php

namespace App\Core\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\BackendController;
use Modules\Movie\Models\Category\Countries;
use Modules\Movie\Models\Category\Genres;
use Modules\Movie\Models\Movie\Movies;
use Modules\Movie\Models\PostCategories;
use Modules\Movie\Models\Posts;

class SitemapController extends BackendController
{
    protected $per_page = 20;
    
    public function index() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-index', 3600);
        $sitemap->addSitemap(route('sitemap.movies'));
        $sitemap->addSitemap(route('sitemap.tv_series'));
        $sitemap->addSitemap(route('sitemap.genres'));
        $sitemap->addSitemap(route('sitemap.countries'));
        $sitemap->addSitemap(route('sitemap.post_categories'));
        $sitemap->addSitemap(route('sitemap.posts'));
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapMovies() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post', 3600);
        $items = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 0)
            ->paginate($this->per_page, ['id']);
        
        $total = $items->lastPage();
        
        for ($i=1; $i<= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.movies.list', [$i]));
        }
        
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapMoviesList($page) {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-posts', 3600);
        $items = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 0)
            ->paginate($this->per_page, ['updated_at', 'slug'], 'page', $page);
        
        foreach ($items as $item) {
            $sitemap->add(route('watch', [$item->slug]), $item->updated_at, '0.8', 'daily');
        }
        
        return $sitemap->render('xml');
    }
    
    public function sitemapTVSeries() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post', 3600);
        $items = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 1)
            ->paginate($this->per_page, ['id']);
        
        $total = $items->lastPage();
        
        for ($i=1; $i<= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.tv_series.list', [$i]));
        }
        
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapTVSeriesList($page) {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-posts', 3600);
        $items = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 1)
            ->paginate($this->per_page, ['updated_at', 'slug'], 'page', $page);
        
        foreach ($items as $item) {
            $sitemap->add(route('watch', [$item->slug]), $item->updated_at, '0.8', 'daily');
        }
        
        return $sitemap->render('xml');
    }
    
    public function sitemapGenres() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post', 3600);
        $items = Genres::where('status', '=', 1)
            ->paginate($this->per_page, ['id']);
        
        $total = $items->lastPage();
        
        for ($i=1; $i<= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.genres.list', [$i]));
        }
        
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapGenresList($page) {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-posts', 3600);
        $items = Genres::where('status', '=', 1)
            ->paginate($this->per_page, ['updated_at', 'slug'], 'page', $page);
        
        foreach ($items as $item)
        {
            $sitemap->add(route('genre', [$item->slug]), $item->updated_at, '0.8', 'daily');
        }
        
        return $sitemap->render('xml');
    }
    
    public function sitemapCountries() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post', 3600);
        $items = Countries::where('status', '=', 1)
            ->paginate($this->per_page, ['id']);
        
        $total = $items->lastPage();
        
        for ($i=1; $i<= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.countries.list', [$i]));
        }
        
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapCountriesList($page) {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-posts', 3600);
        $items = Countries::where('status', '=', 1)
            ->paginate($this->per_page, ['updated_at', 'slug'], 'page', $page);
        
        foreach ($items as $item) {
            $sitemap->add(route('country', [$item->slug]), $item->updated_at, '0.8', 'daily');
        }
        
        return $sitemap->render('xml');
    }
    
    public function sitemapPosts() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post', 3600);
        $items = Posts::where('status', '=', 1)
            ->paginate($this->per_page, ['id']);
        $total = $items->lastPage();
        
        for ($i=1; $i<= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.posts.list', ['page' => $i]));
        }
        
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapPostsList($page) {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-posts', 3600);
        $items = Posts::where('status', '=', 1)
            ->paginate($this->per_page, ['updated_at', 'slug'], 'page', $page);
        
        foreach ($items as $item) {
            //$sitemap->add(route(''), $item->updated_at, '0.8', 'weekly');
        }
        
        return $sitemap->render('xml');
    }
    
    public function sitemapPostCategories() {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post-category', 3600);
        $items = PostCategories::where('status', '=', 1)
            ->paginate($this->per_page, ['id']);
        $total = $items->lastPage();
        
        for ($i=1; $i<= $total; $i++) {
            $sitemap->addSitemap(route('sitemap.post_categories.list', ['page' => $i]));
        }
        
        return $sitemap->render('sitemapindex');
    }
    
    public function sitemapPostCategoriesList($page) {
        $sitemap = \App::make("sitemap");
        $sitemap->setCache('sitemap-post-categories', 3600);
        $items = PostCategories::where('status', '=', 1)
            ->paginate($this->per_page, ['updated_at', 'slug'], 'page', $page);
        
        foreach ($items as $item) {
            //$sitemap->add($item->getLink(), $item->updated_at, '0.8', 'weekly');
        }
        
        return $sitemap->render('xml');
    }
}

<?php

use Juzaweb\Frontend\Http\Controllers\SitemapController;
use Juzaweb\Frontend\Http\Controllers\PostSitemapController;

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');

Route::get('sitemap-{type}-{page}.xml', [PostSitemapController::class, 'index'])->name('sitemap.post_type.index');

Route::get('sitemap/pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');

Route::get(
    'sitemap/{type}/page-{page}.xml',
    [SitemapController::class, 'sitemapPost']
)->name('sitemap.posts');

Route::get(
    'sitemap/taxonomy/{type}/page-{page}.xml',
    [SitemapController::class, 'sitemapTaxonomy']
)->name('sitemap.taxonomies');

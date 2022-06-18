<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

require __DIR__ . '/components/profile.route.php';

use Juzaweb\CMS\Support\Installer;
use Juzaweb\CMS\Support\Route\Auth;
use Juzaweb\Frontend\Http\Controllers\AjaxController;
use Juzaweb\Frontend\Http\Controllers\FeedController;
use Juzaweb\Frontend\Http\Controllers\HomeController;
use Juzaweb\Frontend\Http\Controllers\PostController;
use Juzaweb\Frontend\Http\Controllers\RouteController;
use Juzaweb\Frontend\Http\Controllers\SearchController;
use Juzaweb\Frontend\Http\Controllers\SitemapController;

Auth::routes();

Route::get(
    'sitemap.xml',
    [SitemapController::class, 'index']
)->name('sitemap.index');

Route::get(
    'sitemap/pages.xml',
    [SitemapController::class, 'pages']
)->name('sitemap.pages');

Route::get(
    'sitemap/{type}/page-{page}.xml',
    [SitemapController::class, 'sitemapPost']
)->name('sitemap.posts');

Route::get(
    'sitemap/taxonomy/{type}/page-{page}.xml',
    [SitemapController::class, 'sitemapTaxonomy']
)->name('sitemap.taxonomies');

Route::get('feed', [FeedController::class, 'index'])->name('feed');
Route::get('taxonomy/{taxonomy}/feed', [FeedController::class, 'taxonomy'])->name('feed.taxonomy');

Route::match(
    ['get', 'post'],
    'ajax/{slug}',
    [AjaxController::class, 'ajax']
)
    ->name('ajax')
    ->where('slug', '[a-z\-\/]+');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], 'search', [SearchController::class, 'index'])->name('search');

Route::match(
    ['get', 'post'],
    'search/ajax',
    [SearchController::class, 'ajaxSearch']
)->name('ajax.search');

if (Installer::alreadyInstalled()) {
    Route::post(
        '{slug}',
        [PostController::class, 'comment']
    )
        ->name('comment')
        ->where('slug', '^(?!admin\-cp|api\/).*$');

    Route::get('{slug}', [RouteController::class, 'index'])
        ->where('slug', '^(?!admin\-cp|api\/).*$')
        ->name('post');
}

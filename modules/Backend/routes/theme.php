<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

require __DIR__ . '/components/theme.profile.php';

use Juzaweb\Backend\Http\Controllers\Frontend\HomeController;
use Juzaweb\Backend\Http\Controllers\Frontend\AjaxController;
use Juzaweb\Backend\Http\Controllers\Frontend\SearchController;
use Juzaweb\Backend\Http\Controllers\Frontend\PostController;
use Juzaweb\Backend\Http\Controllers\Frontend\RouteController;
use Juzaweb\Seo\Http\Controllers\FeedController;
use Juzaweb\Seo\Http\Controllers\SitemapController;
use Juzaweb\CMS\Support\Installer;
use Juzaweb\CMS\Support\Route\Auth;

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

Route::match(['get', 'post'], 'ajax/{slug}', [AjaxController::class, 'ajax'])->name('ajax');

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
        ->where('slug', '^(?!admin\-cp|api\/|subscription\/).*$');
    
    Route::get('{slug}', [RouteController::class, 'index'])
        ->where('slug', '^(?!admin\-cp|api\/|subscription\/).*$');
}

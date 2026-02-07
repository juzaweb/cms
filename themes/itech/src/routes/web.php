<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\Themes\Itech\Http\Controllers\BlogController;
use Juzaweb\Themes\Itech\Http\Controllers\HomeController;
use Juzaweb\Themes\Itech\Http\Controllers\PageController;
use Juzaweb\Themes\Itech\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/load-more', [HomeController::class, 'loadMore'])->name('home.load-more');
Route::get('/load-posts', [HomeController::class, 'loadPosts'])->name('home.load-posts');

// Route::get('page-{page?}.html', [HomeController::class, 'index'])
//     ->where('page', '[0-9]+');
Route::get('/post/{slug}', [BlogController::class, 'show'])->name('post.show');
Route::post('/post/{slug}', [BlogController::class, 'comment'])->name('post.comment')->middleware('throttle:6,1');

Route::get('/post/category/{slug}', [BlogController::class, 'category'])->name('blog.category');

Route::group(
    ['middleware' => ['auth:member', 'verified']],
    function () {
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('profile', [ProfileController::class, 'update'])->name('profile');
    }
);

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');

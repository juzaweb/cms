<?php

use Juzaweb\Frontend\Http\Controllers\AjaxController;
use Juzaweb\Frontend\Http\Controllers\HomeController;
use Juzaweb\Frontend\Http\Controllers\PostController;
use Juzaweb\Frontend\Http\Controllers\RouteController;
use Juzaweb\Frontend\Http\Controllers\SearchController;
use Juzaweb\CMS\Support\Installer;

Route::match(
    ['get', 'post', 'put'],
    'ajax/{slug}',
    [AjaxController::class, 'ajax']
)
    ->name('ajax')
    ->where('slug', '[a-z0-9\-\/]+');

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

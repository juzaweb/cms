<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\API\Http\Controllers\PostController;
use Juzaweb\API\Http\Controllers\CommentController;

Route::group(
    [
        'prefix' => 'post-type',
    ],
    function () {
        Route::get('{type}', [PostController::class, 'index']);
        Route::get('{type}/{slug}', [PostController::class, 'show']);
        Route::get('{type}/{slug}/related', [PostController::class, 'related']);
        Route::get('{type}/{slug}/comments', [CommentController::class, 'index']);
        Route::post('{type}/{slug}/comments', [CommentController::class, 'store']);
    }
);

<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\CommentController;
use Juzaweb\Backend\Http\Controllers\Backend\TaxonomyController;
use Juzaweb\Backend\Http\Controllers\Backend\PostController;

Route::jwResource(
    'post-type/{type}/comments',
    CommentController::class,
    [
        'name' => 'comments'
    ]
);

Route::jwResource(
    'taxonomy/{type}/{taxonomy}',
    TaxonomyController::class,
    [
        'name' => 'taxonomies'
    ]
);

Route::get(
    'taxonomy/{type}/{taxonomy}/component-item',
    [TaxonomyController::class, 'getTagComponent']
);

Route::jwResource(
    'post-type/{type}',
    PostController::class,
    [
        'name' => 'posts'
    ]
);

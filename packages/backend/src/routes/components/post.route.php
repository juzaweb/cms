<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

Route::jwResource('post-type/{type}/comments', 'Backend\CommentController', [
    'name' => 'comments'
]);

Route::jwResource('taxonomy/{type}/{taxonomy}', 'Backend\TaxonomyController', [
    'name' => 'taxonomies'
]);

Route::get('taxonomy/{type}/{taxonomy}/component-item', 'Backend\TaxonomyController@getTagComponent');

Route::jwResource('post-type/{type}', 'Backend\PostController', [
    'name' => 'posts'
]);




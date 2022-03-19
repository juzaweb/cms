<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

Route::jwResource('resources/{type}-{post}', 'Backend\PostResourceController', [
    'name' => 'post_resource'
]);

Route::jwResource('resources/{type}-{post}/parent/{parent}', 'Backend\ChildResourceController', [
    'name' => 'child_resource'
]);

Route::jwResource('resources/{type}', 'Backend\ResourceController', [
    'name' => 'resource'
]);

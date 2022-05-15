<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\ResourceController;
use Juzaweb\Backend\Http\Controllers\Backend\ChildResourceController;
use Juzaweb\Backend\Http\Controllers\Backend\PostResourceController;

Route::jwResource(
    'resources/{type}-{post}',
    'Backend\PostResourceController',
    [
        'name' => 'post_resource'
    ]
);

Route::jwResource(
    'resources/{type}-{post}/parent/{parent}',
    'Backend\ChildResourceController',
    [
        'name' => 'child_resource'
    ]
);

Route::jwResource(
    'resources/{type}',
    'Backend\ResourceController',
    [
        'name' => 'resource'
    ]
);

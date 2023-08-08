<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\ResourceController;
use Juzaweb\Backend\Http\Controllers\Backend\ChildResourceController;
use Juzaweb\Backend\Http\Controllers\Backend\PostResourceController;

Route::jwResource(
    'resources/{type}/{post}',
    PostResourceController::class,
    [
        'name' => 'post_resource',
        'where' => ['post' => '[0-9]+'],
    ]
);

Route::jwResource(
    'resources/{type}/{post}/parent/{parent}',
    ChildResourceController::class,
    [
        'name' => 'child_resource',
        'where' => ['post' => '[0-9]+', 'parent' => '[0-9]+'],
    ]
);

Route::jwResource(
    'resources/{type}',
    ResourceController::class,
    [
        'name' => 'resource',
    ]
);

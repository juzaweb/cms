<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\API\PostController;

Route::group(
    [
        'prefix' => 'post-types',
        'middleware' => 'auth:sanctum',
    ],
    function () {
        Route::apiResource(
            '{types}',
            PostController::class,
            [
                'parameters' => [
                    '{types}' => 'id',
                ],
                'names' => 'post_type',
            ]
        );
    }
);

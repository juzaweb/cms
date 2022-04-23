<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
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

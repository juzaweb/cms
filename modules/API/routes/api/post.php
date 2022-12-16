<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\API\Http\Controllers\PostController;

Route::group(
    [
        'prefix' => 'post-type',
    ],
    function () {
        Route::apiResource(
            '{type}',
            PostController::class,
            [
                'parameters' => [
                    '{type}' => 'slug',
                ],
                'names' => 'post_type',
            ]
        );
    }
);

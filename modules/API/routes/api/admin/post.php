<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\API\Http\Controllers\Admin\PostController;

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
                    '{type}' => 'id',
                ],
                'names' => 'post_type',
            ]
        );
    }
);

<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

use Juzaweb\API\Http\Controllers\Admin\DataTableController;

Route::group(
    [
        'prefix' => 'datatable',
    ],
    function () {
        Route::get('/{id}', [DataTableController::class, 'show']);
        //Route::get('/{id}/data', [DataTableController::class, 'getData']);
    }
);

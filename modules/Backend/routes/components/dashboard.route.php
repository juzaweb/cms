<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\DashboardController;
use Juzaweb\Backend\Http\Controllers\Backend\LoadDataController;
use Juzaweb\Backend\Http\Controllers\Backend\UpdateController;
use Juzaweb\Backend\Http\Controllers\Backend\AjaxController;

Route::group(
    ['prefix' => '/'],
    function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/load-data/{func}', 'Backend\LoadDataController@loadData')->name('admin.load_data');

        Route::get(
            '/dashboard/users',
            'Backend\DashboardController@getDataUser'
        )
            ->name('admin.dashboard.users');

        Route::get(
            '/dashboard/top-views',
            'Backend\DashboardController@getDataTopViews'
        )->name('admin.dashboard.top_views');

        Route::get(
            '/dashboard/views-chart',
            [DashboardController::class, 'viewsChart']
        )->name('admin.dashboard.views_chart');

        Route::get(
            '/datatable/get-data',
            'Backend\DatatableController@getData'
        )
            ->name('admin.datatable.get-data');

        Route::post(
            '/datatable/bulk-actions',
            'Backend\DatatableController@bulkActions'
        )->name('admin.datatable.bulk-actions');

        Route::post(
            '/remove-message',
            [DashboardController::class, 'removeMessage']
        )->name('admin.dashboard.remove-message');
    }
);

Route::any('/ajax/{slug}', 'Backend\AjaxController@handle')->name('admin.ajax')->where('slug', '[a-z0-9\-\/]+');

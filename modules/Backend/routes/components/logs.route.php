<?php

use Juzaweb\Backend\Http\Controllers\Backend\EmailLogController;
use Juzaweb\Backend\Http\Controllers\Backend\LogViewerController;

Route::get('logs/email', [EmailLogController::class, 'index'])->name('admin.logs.email');

if (!config('log-viewer.route.enabled')) {
    Route::group(
        [
            'prefix' => 'log-viewer'
        ],
        function () {
            Route::get('/', [LogViewerController::class, 'index'])->name('admin.logs.error.index');
            Route::get('get-logs', [LogViewerController::class, 'listLogs'])
                ->name('admin.logs.error.get-logs');
            Route::get('{date}', [LogViewerController::class, 'show'])
                ->name('admin.logs.error.show')
                ->where('date', '[0-9\-]+');
            Route::get('download/{date}', [LogViewerController::class, 'download'])
                ->name('admin.logs.error.download')
                ->where('date', '[0-9\-]+');
            Route::get('search/{date}', [LogViewerController::class, 'search'])
                ->name('admin.logs.error.search')
                ->where('date', '[0-9\-]+');
            Route::delete('/', [LogViewerController::class, 'delete'])
                ->name('admin.logs.error.delete');
        }
    );
}

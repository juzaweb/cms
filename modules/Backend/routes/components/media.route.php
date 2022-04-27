<?php

use Juzaweb\Backend\Http\Controllers\Backend\MediaController;

Route::group(
    ['prefix' => 'media'],
    function (): void {
        Route::get('/', [MediaController::class, 'index'])->name('admin.media.index');
        Route::get(
            '/folder/{folder}',
            [MediaController::class, 'index']
        )
            ->name('admin.media.folder')
            ->where('folder', '[0-9]+');

        Route::post('/add-folder', [MediaController::class, 'addFolder'])->name('admin.media.add-folder');
    }
);

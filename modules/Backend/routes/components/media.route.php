<?php

use Juzaweb\Backend\Http\Controllers\Backend\MediaController;

Route::group(
    ['prefix' => 'media'],
    function (): void {
        Route::get('/', [MediaController::class, 'index'])->name('admin.media.index');
        Route::put('/{id}', [MediaController::class, 'update'])->name('admin.media.update');
        Route::delete('/{id}', [MediaController::class, 'destroy'])->name('admin.media.destroy');
        Route::get('/{id}/download', [MediaController::class, 'download'])->name('admin.media.download');

        Route::get(
            '/folder/{folder}',
            [MediaController::class, 'index']
        )
            ->name('admin.media.folder')
            ->where('folder', '[0-9]+');

        Route::post('/add-folder', [MediaController::class, 'addFolder'])->name('admin.media.add-folder');
    }
);

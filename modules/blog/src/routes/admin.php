<?php

use Juzaweb\Modules\Blog\Http\Controllers\CategoryController;
use Juzaweb\Modules\Blog\Http\Controllers\PostController;

Route::admin('posts', PostController::class);
Route::admin('post-categories', CategoryController::class);

Route::post('/post-categories/quick-store', [CategoryController::class, 'quickStore'])
    ->name('admin.post-categories.quick-store');

<?php

use Juzaweb\Crawler\Http\Controllers\ComponentController;
use Juzaweb\Crawler\Http\Controllers\LinkController;
use Juzaweb\Crawler\Http\Controllers\TemplateController;

Route::group(
    ['prefix' => 'crawler/template'],
    function () {
        Route::post('/preview', [TemplateController::class, 'preview']);
        Route::jwResource('/', TemplateController::class);
    }
);

Route::group(
    ['prefix' => '/template/components/{template_id}'],
    function () {
        Route::get('/', [ComponentController::class, 'index'])->name('admin.crawler_component.index');
        Route::post('/', [ComponentController::class, 'save']);
        Route::post('/preview', [ComponentController::class, 'preview'])->name('admin.crawler_component.preview');
    }
);

Route::group(
    ['prefix' => '/template/links/{template_id}'],
    function () {
        Route::jwResource(
            '/',
            LinkController::class,
            [
                'name' => 'crawler_link'
            ]
        );
    }
);

<?php

use Mymo\Core\Facades\HookAction;

HookAction::registerPostType('posts', [
    'label' => trans('mymo_core::app.posts'),
    'model' => \Mymo\PostType\Models\Post::class,
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 15,
    'supports' => ['category', 'tag'],
]);

HookAction::registerPostType('pages', [
    'label' => trans('mymo_core::app.pages'),
    'model' => \Mymo\PostType\Models\Page::class,
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 15,
    'supports' => [],
]);

HookAction::addAdminMenu(
    trans('mymo_core::app.comments'),
    'comments',
    [
        'icon' => 'fa fa-comments',
        'position' => 30
    ]
);

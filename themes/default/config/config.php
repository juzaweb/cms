<?php

return [
    'styles' => [
        'js' => [
            'assets/js/main.js'
        ],
        'css' => [
            'assets/css/main.css',
        ]
    ],
    'templates' => [
        'home' => [
            'name' => trans('juzaweb::app.home'),
            'view' => 'templates.home'
        ]
    ],
    'nav_menus' => [
        'primary' => trans('theme::content.primary_menu'),
    ],
];

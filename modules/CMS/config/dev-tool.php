<?php

return [
    // Enable dev tool in production
    'enable' => env('JW_DEV_TOOL_ENABLE', false),

    'themes' => [
        'options' => [
            'post-types/create' => [
                'label' => 'Make Custom Post Type',
            ],
            'taxonomies/create' => [
                'label' => 'Make Custom Taxonomy',
            ],
            'settings' => [
                'label' => 'Make Theme Setting',
            ],
        ]
    ],

    'plugins' => [
        'options' => [
            'make-custom-post-type' => [
                'label' => 'Make Custom Post Type',
            ],
            'make-custom-taxonomy' => [
                'label' => 'Make Custom Taxonomy',
            ],
            'make-crud' => [
                'label' => 'Make CRUD',
            ],
            'make-migration' => [
                'label' => 'Make Migration',
            ],
        ],
        'menus' => [
            'post-types' => [
                'label' => 'Post Types',
            ]
        ]
    ]
];

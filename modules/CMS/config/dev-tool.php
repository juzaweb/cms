<?php

return [
    // Enable dev tool in production
    'enable' => env('JW_DEV_TOOL_ENABLE', false),

    'themes' => [
        'options' => [
            //
        ]
    ],

    'plugins' => [
        'options' => [
            'make-custom-post-type' => [
                'label' => 'Make Custom Post Type',
            ],
            'make-custom-taxonomy' => [
                'label' => 'Make Custom Taxonomy',
            ]
        ],
        'menus' => [
            'post-types' => [
                'label' => 'Post Types',
            ]
        ]
    ]
];

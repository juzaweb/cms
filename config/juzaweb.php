<?php

use Juzaweb\CMS\Facades\Facade;

return [
    /**
     * Admin url prefix
     *
     * Default: admin-cp
     */
    'admin_prefix' => env('ADMIN_PREFIX', 'admin-cp'),

    /**
     * Cache prefix
     *
     * Default: juzaweb_
     */

    'cache_prefix' => 'juzaweb_',

    /**
     * Show logs in admin page
     */
    'logs_viewer' => true,

    'email' => [
        /**
         * Method send email
         *
         * Support: sync, queue, cron
         * Default: sync
         */
        'method' => env('EMAIL_METHOD', 'sync'),
    ],

    'theme' => [
        /**
         * Enable upload themes
         *
         * Default: true
         */
        'enable_upload' => (bool) env('ENABLE_UPLOAD_THEME', true),

        /**
         * Themes path
         *
         * This path used for save the generated theme. This path also will added
         * automatically to list of scanned folders.
         */
        'path' => base_path('themes'),
    ],

    'plugin' => [
        /**
         * Enable upload plugins
         *
         * Default: true
         */
        'enable_upload' => (bool) env('ENABLE_UPLOAD_PLUGIN', true),

        /**
         * Path plugins folder
         *
         * Default: plugins
         */
        'path' => base_path('plugins'),

        /**
         * Plugins assets path
         *
         * Path for assets when it was published
         * Default: plugins
         */
        'assets' => public_path('plugins'),
    ],

    'performance' => [
        /**
         * Minify views when compile
         *
         * Default: true
         */
        'minify_views' => true,

        /**
         * Deny iframe to website
         *
         * Default: true
         */
        'deny_iframe' => true,

    ],

    /**
     * File management setting
     */
    'filemanager' => [
        /**
         * FileSystem upload disk
         */
        'disk' => 'public',

        /**
         * Optimizer image after upload
         *
         * @see https://juzaweb.com/documentation/start/image-optimizer
         */
        'image-optimizer' => (bool) env('IMAGE_OPTIMIZER', false),

        'image_mimetypes' => Facade::defaultImageMimetypes()->merge(
            [
                // ...
            ]
        )->toArray(),

        'svg_mimetypes' => Facade::defaultSVGMimetypes()->merge(
            [
                // ...
            ]
        )->toArray(),

        /**
         * File type
         *
         * Default: file, image
         */
        'types' => [
            'file'  => [
                'max_size' => 50, // size in MB
                'valid_mime' => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/svg+xml',
                    'application/pdf',
                    'text/plain',
                    'text/xml',
                ],
            ],
            'image' => [
                'max_size' => 5, // size in MB
                'valid_mime' => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/svg+xml',
                ],
            ],
        ],
    ],

    'config' => Facade::defaultConfigs()->merge(
        [
            // ...
        ]
    )->toArray()
];

<?php
/**
 * MYMO CMS - The Best Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/27/2021
 * Time: 8:37 PM
*/

return [
    'admin_prefix' => env('ADMIN_PREFIX', 'admin-cp'),

    'plugin' => [
        /**
         * Plugins path
         *
         * This path used for save the generated plugin. This path also will added
        automatically to list of scanned folders.
         */
        'path' => base_path('plugins'),
        /**
         * Plugins assets path
         *
         * Path for assets when it was publish
         * Default: plugins
         */
        'assets'    => public_path('plugins'),
    ],

    'theme' => [
        /**
         * Themes path
         *
         * This path used for save the generated theme. This path also will added
         automatically to list of scanned folders.
         */
        'path' => base_path('themes'),
        /*
        |--------------------------------------------------------------------------
        | Themes folder structure
        |--------------------------------------------------------------------------
        |
        | Here you may update theme folder structure.
        |
        */
        'folders' => [
            'assets'  => 'assets',
            'views'   => 'views',
            'lang'    => 'lang',
            'lang/en' => 'lang/en',
            'css' => 'assets/css',
            'js'  => 'assets/js',
            'img' => 'assets/images',
            'layouts' => 'views/layouts',
        ],
    ],

    'email' => [
        /**
         * Support: sync, queue, cron
         * Default: sync
         * */
        'method' => 'sync'
    ],

    'notification' => [
        /**
         * Support: sync, queue, cron
         * Default: sync
         * */
        'method' => 'sync',
        /**
         * Support: database, mail
         * */
        'via' => [
            'database' => [
                'enable' => true,
            ],
            'mail' => [
                'enable' => true,
                'connection' => 'default',
            ]
        ]
    ],

    'filemanager' => [
        'disk' => 'public',
        'types' => [
            'file'  => [
                'max_size'     => 50000, // size in KB
                'valid_mime'   => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/svg+xml',
                    'application/pdf',
                    'text/plain',
                ],
            ],
            'image' => [
                'max_size'     => 50000, // size in KB
                'valid_mime'   => [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/gif',
                    'image/svg+xml',
                ],
            ],
        ],
    ]
];

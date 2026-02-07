<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('STORAGE_URL', env('APP_URL').'/storage'),
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

        'cloud' => [
            'driver' => 's3',
            'key' => env('S3_CLOUD_KEY_ID'),
            'secret' => env('S3_CLOUD_SECRET'),
            'region' => env('S3_CLOUD_REGION'),
            'bucket' => env('S3_CLOUD_BUCKET'),
            'endpoint' => env('S3_CLOUD_ENDPOINT'),
            'write_endpoint' => env('S3_CLOUD_WRITE_ENDPOINT'), // Optional custom endpoint for write operations
            'bucket_endpoint' => true,
            'use_path_style_endpoint' => false,
            'throw' => true,
            'visibility' => 'public',
            'url' => env('S3_CLOUD_URL'),
            'proxy_url' => env('S3_CLOUD_PROXY_URL'),
            /**
             * If enabled, media files will be served through a route in the application
             * instead of directly from the cloud storage URL. This can be useful for
             * handling access control, logging, or modifying the response.
             *
             * Default route: /media/{path}
             */
            'stream_route' => (bool) env('S3_CLOUD_STREAM_ROUTE', false),
        ],

        'private' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'throw' => false,
            'report' => false,
        ],

        'tmp' => [
            'driver' => 'local',
            'root' => storage_path('app/tmp'),
            'throw' => false,
            'report' => false,
        ],

        'trash' => [
            'driver' => 'local',
            'root' => storage_path('app/trash'),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

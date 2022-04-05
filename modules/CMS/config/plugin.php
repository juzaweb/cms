<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Support\Activators\DbActivator;

return [
    /*
    |--------------------------------------------------------------------------
    | Autoload Plugin
    |--------------------------------------------------------------------------
    | Plugin namespace autoload if active, if false, you can run `composer require vendor/plugin` to enable plugin
    */
    'autoload' => env('AUTOLOAD_PLUGIN', true),
    
    /**
     * Activator helper
     */
    'activator' => DbActivator::class,
    
    'stubs' => [
        'enabled' => true,
        'files' => [
            'routes/admin' => 'src/routes/admin.php',
            'routes/api' => 'src/routes/api.php',
            'views/index' => 'src/resources/views/index.blade.php',
            'lang/en' => 'src/resources/lang/en/content.php',
            'composer' => 'composer.json',
            //'webpack' => 'webpack.mix.js',
            //'package' => 'package.json',
        ],
        'replacements' => [
            'routes/admin' => ['LOWER_NAME', 'STUDLY_NAME'],
            'routes/api' => ['LOWER_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'SNAKE_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAME',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
                'MODULE_DOMAIN'
            ],
        ]
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'config' => ['path' => 'Config', 'generate' => false],
            'command' => ['path' => 'src/Commands', 'generate' => false],
            'action' => ['path' => 'src/Actions', 'generate' => false],
            'migration' => ['path' => 'database/migrations', 'generate' => true],
            'seeder' => ['path' => 'database/seeders', 'generate' => true],
            'factory' => ['path' => 'database/factories', 'generate' => true],
            'model' => ['path' => 'src/Models', 'generate' => true],
            'routes' => ['path' => 'src/routes', 'generate' => true],
            'controller' => ['path' => 'src/Http/Controllers', 'generate' => true],
            'filter' => ['path' => 'src/Http/Middleware', 'generate' => false],
            'request' => ['path' => 'src/Http/Requests', 'generate' => false],
            'datatable' => ['path' => 'src/Http/Datatables', 'generate' => true],
            'provider' => ['path' => 'src/Providers', 'generate' => true],
            'assets' => ['path' => 'src/resources/assets', 'generate' => true],
            'assets_js' => ['path' => 'src/resources/assets/js', 'generate' => true],
            'assets_css' => ['path' => 'src/resources/assets/css', 'generate' => true],
            'lang' => ['path' => 'src/resources/lang', 'generate' => true],
            'views' => ['path' => 'src/resources/views', 'generate' => true],
            'test' => ['path' => 'tests/Unit', 'generate' => true],
            'test-feature' => ['path' => 'tests/Feature', 'generate' => true],
            'repository' => ['path' => 'src/Repositories', 'generate' => false],
            'event' => ['path' => 'src/Events', 'generate' => false],
            'listener' => ['path' => 'src/Listeners', 'generate' => false],
            'policies' => ['path' => 'src/Policies', 'generate' => false],
            'rules' => ['path' => 'src/Rules', 'generate' => false],
            'jobs' => ['path' => 'src/Jobs', 'generate' => false],
            'emails' => ['path' => 'src/Emails', 'generate' => false],
            'notifications' => ['path' => 'src/Notifications', 'generate' => false],
            'resource' => ['path' => 'src/Transformers', 'generate' => false],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'juzaweb-plugins',
        'lifetime' => 60,
    ]
];

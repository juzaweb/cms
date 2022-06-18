<?php

if (file_exists(__DIR__ . '/../define.php')) {
    require __DIR__ . '/../define.php';
}

require __DIR__ . '/define.php';

$loader = require __DIR__.'/../vendor/autoload.php';

if (!file_exists(JW_BASE_PATH . '/.env')) {
    copy(JW_BASE_PATH . '/.env.example', JW_BASE_PATH . '/.env');
    file_put_contents(
        JW_BASE_PATH . '/.env',
        str_replace(
            [
                "APP_KEY=".PHP_EOL.'APP_DEBUG=true'
            ],
            [
                'APP_KEY=base64:'.base64_encode(\Illuminate\Support\Str::random(32)).PHP_EOL.'APP_DEBUG=true'
            ],
            file_get_contents(JW_BASE_PATH . '/.env')
        )
    );

    if (file_exists(JW_BASE_PATH . '/storage/app/installed')) {
        unlink(JW_BASE_PATH . '/storage/app/installed');
    }
}

if (JW_PLUGIN_AUTOLOAD) {
    $autoloadPsr4 = __DIR__ . '/../bootstrap/cache/plugin_autoload_psr4.php';
    if (file_exists($autoloadPsr4)) {
        $map = require $autoloadPsr4;
        foreach ($map as $namespace => $path) {
            $loader->addPsr4($namespace, $path);
        }
    }

    $autoloadFiles = __DIR__ . '/../bootstrap/cache/plugin_autoload_files.php';
    if (file_exists($autoloadFiles)) {
        $includeFiles = require $autoloadFiles;
        foreach ($includeFiles as $file) {
            if (file_exists($file)) {
                require $file;
            }
        }
    }
}

return $loader;

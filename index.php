<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

const JW_BASE_PATH = __DIR__ . '/..';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

if (file_exists(__DIR__.'/vendor/juzaweb/core/helpers/before-init.php')) {
    require __DIR__.'/vendor/juzaweb/core/helpers/before-init.php';
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());

<?php

$loader = require __DIR__.'/../vendor/autoload.php';

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
        require $file;
    }
}

return $loader;

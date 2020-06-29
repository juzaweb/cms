<?php

function image_url($path) {
    if ($path) {
        $storage_path = Storage::path('/');
        if (file_exists($storage_path . '/' . $path)) {
            return '/filemanager/' . $path;
        }
    }
    
    return asset('imgs/default.png');
}
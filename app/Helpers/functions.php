<?php

function json_message($message, $status = 'success') {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

function image_path($url) {
    $img = explode('uploads/', $url);
    if ($img[1]) {
        return $img[1];
    }
    
    return null;
}

function image_url($path) {
    if ($path) {
        $storage_path = Storage::disk('uploads')->path('/');
        
        if (file_exists($storage_path . '/' . $path)) {
            return '/storage/uploads/' . $path;
        }
    }
    
    return asset('images/thumb-default.png');
}
<?php

namespace App\Http\Controllers\Frontend\Stream;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StreamController extends Controller
{
    public function stream($file, $quality = '360p') {
        $stream = base64_decode(urldecode($file));
        $stream = json_decode($stream);
        
        $class = 'App\Http\Controllers\Frontend\Stream\\'. $stream->class .'Controller';
        if (class_exists($class)) {
            $controller = new $class();
            $controller->stream($file, $quality);
        }
        
        abort(404);
    }
}

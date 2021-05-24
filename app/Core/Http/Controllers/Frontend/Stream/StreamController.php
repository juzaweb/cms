<?php

namespace App\Core\Http\Controllers\Frontend\Stream;

use App\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class StreamController extends Controller
{
    public function stream($file, $quality = '360p')
    {
        $stream = base64_decode(urldecode($file));
        $stream = json_decode(Crypt::decryptString($stream));
        
        $class = 'App\Core\Http\Controllers\Frontend\Stream\\'. $stream->class .'Controller';
        if (class_exists($class)) {
            $controller = new $class();
            $controller->stream($file, $quality);
        }
        
        abort(404);
    }
}

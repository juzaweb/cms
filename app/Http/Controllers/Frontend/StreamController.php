<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\VideoStream;
use App\Http\Controllers\Controller;

class StreamController extends Controller
{
    public function image($path) {
        if (explode('/', $path)[0] !== 'files') {
            $path = \Storage::disk('uploads')->path($path);
            if (file_exists($path)) {
                return response()->file($path);
            }
        }
        
        return abort(404);
    }
    
    public function video($token, $file, $file_name) {
        if (!VideoStream::checkToken($token)) {
            die('Token do not match');
        }
    
        try {
            $file = json_decode(\Crypt::decryptString($file));
            if ($file->path) {
                if (\Storage::disk('uploads')->exists($file->path)) {
                    $file_path = \Storage::disk('uploads')->path($file->path);
                    $stream = new VideoStream($file_path);
                    $stream->start();
                }
            }
        }
        catch (\Exception $exception) {
            \Log::error('VideoStream: ' . $exception->getMessage());
            die('Token do not match');
        }
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\VideoStream;
use App\Http\Controllers\Controller;
use App\Helpers\UrlVideoStream;

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
        if (!VideoStream::checkToken($token, $file_name)) {
            die('Token do not match');
        }
    
        try {
            $file = json_decode(\Crypt::decryptString($file));
            if ($file->path) {
                
                if (is_url($file->path)) {
    
                    //$stream = new UrlVideoStream($file->path);
                    //$stream->start();
                    
                    return response()->streamDownload(function () use ($file) {
                        echo file_get_contents($file->path);
                    }, 'video.mp4');
                }
                
                if (\Storage::disk('uploads')->exists($file->path)) {
                    $file_path = \Storage::disk('uploads')->path($file->path);
                    $stream = new VideoStream($file_path);
                    $stream->start();
                    die();
                }
            }
        }
        catch (\Exception $exception) {
            \Log::error('VideoStream: ' . $exception->getMessage());
            die('Token do not match');
        }
    }
}

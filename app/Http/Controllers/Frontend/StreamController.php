<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\VideoStream;
use App\Http\Controllers\Controller;
use App\Helpers\UrlVideoStream;

class StreamController extends Controller
{
    public function image($path) {
        if (explode('/', $path)[0] !== 'files') {
            $path = \Storage::disk('public')->path($path);
            if (file_exists($path)) {
                return response()->file($path);
            }
        }
        
        return abort(404);
    }
    
    public function video($token, $file, $file_name) {
        if (!check_token($token, $file_name)) {
            die('Token do not match');
        }
    
        //try {
            $file = json_decode(\Crypt::decryptString(base64_decode($file)));
            if ($file->path) {
            
                if (is_url($file->path)) {
                    $this->urlFileStream($file);
                    die();
                }
            
                if (\Storage::disk('uploads')->exists($file->path)) {
                    $this->localFileStream($file);
                    die();
                }
            }
        /*}
        catch (\Exception $exception) {
            \Log::error('VideoStream: ' . $exception->getMessage());
            die('Token do not match.');
        }*/
    }
    
    protected function urlFileStream($file) {
        $stream = new UrlVideoStream($file->path);
        $stream->start();
    }
    
    protected function localFileStream($file) {
        $file_path = \Storage::disk('uploads')->path($file->path);
        $stream = new VideoStream($file_path);
        $stream->start();
    }
    
    protected function isUrlGoogleDrive($url) {
        if (strpos($url, 'drive.google.com') !== false) {
            return true;
        }
        
        return false;
    }
}

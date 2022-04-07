<?php

namespace Juzaweb\Movie\Http\Controllers\Frontend;

use Juzaweb\Multisite\Core\Helpers\VideoStream;
use Juzaweb\Multisite\Core\Helpers\UrlVideoStream;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class StreamController extends FrontendController
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
            
                if (\Storage::disk('public')->exists($file->path)) {
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
        $file_path = \Storage::disk('public')->path($file->path);
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

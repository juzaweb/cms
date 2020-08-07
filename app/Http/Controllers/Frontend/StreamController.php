<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\GoogleDrive;
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
        if (!check_token(base64_decode($token), $file_name)) {
            die('Token do not match');
        }
    
        try {
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
        }
        catch (\Exception $exception) {
            \Log::error('VideoStream: ' . $exception->getMessage());
            die('Token do not match.');
        }
    }
    
    protected function urlFileStream($file) {
        if ($this->isUrlGoogleDrive($file->path)) {
            $this->googleDriveStream($file);
        }
        else {
            $stream = new UrlVideoStream($file->path);
            $stream->start();
        }
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
    
    protected function googleDriveStream($file) {
        $gdrive = new GoogleDrive($file->path);
        $this->googleDriveStream($gdrive->getDataStream($file->key));
    }
    
    protected function googleDriveStreamData(array $data) {
        $content_length = $data['content_length'];
        $headers = [
            'Connection: keep-alive',
            'Cookie: DRIVE_STREAM=' . $data['drive_stream']
        ];
        
        if (isset($_SERVER['HTTP_RANGE'])) {
            $http = 1;
            preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $range);
            $initial = intval($range[1]);
            $final = $content_length - $initial - 1;
            array_push($headers,'Range: bytes=' . $initial . '-' . ($initial + $final));
        } else {
            $http = 0;
        }
        
        if ($http == 1) {
            header('HTTP/1.1 206 Partial Content');
            header('Accept-Ranges: bytes');
            header('Content-Range: bytes ' . $initial . '-' . ($initial + $final) . '/' . $data['content-length']);
        } else {
            header('Accept-Ranges: bytes');
        }
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $data['src'],
            CURLOPT_CONNECTTIMEOUT => 0,
            CURLOPT_TIMEOUT => 1000,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_HTTPHEADER => $headers
        ));
        
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($curl, $body) {
            echo $body;
            return strlen($body);
        });
        
        header('Content-Type: video/mp4');
        header('Content-length: ' . $content_length);
        curl_exec($ch);
    }
}

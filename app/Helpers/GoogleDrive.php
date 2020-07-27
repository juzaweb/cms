<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class GoogleDrive
{
    protected $file_id;
    
    public function __construct(string $url) {
        $this->file_id = static::getFileId($url);
    }
    
    public function getLinkPlay() {
        $play_url = 'https://drive.google.com/file/d/'. $this->file_id .'/view';
        $client = new Client();
        $response = $client->request('GET', $play_url);
        $content = $response->getBody();
        
        $start = strpos($content, '"fmt_stream_map"');
        if ($start === false) {
            return false;
        }
        
        $length = strpos(substr($content, $start), ']');
        $stream_map = '[' . substr($content, $start, $length) . ']';
        $stream_map = json_decode($stream_map, true)[1];
        $stream_map = explode(',', $stream_map);
    
        $files = [];
        foreach ($stream_map as $file) {
            $explode = explode('|', $file);
            switch ($explode[0]) {
                case 18: $quality = '360p';break;
                case 22: $quality = '720p';break;
                default: $quality = '360p';
            }
            
            $files[] = (object) [
                'label' => $quality,
                'type' => 'mp4',
                'url' => $explode[1],
            ];
        }
        
        return $files;
    }
    
    public static function getFileId(string $url) {
        return explode('/', $url)[5];
    }
}
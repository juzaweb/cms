<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class GoogleDrive
{
    protected $file_id;
    
    public function __construct(string $url) {
        $this->file_id = $this->getFileId($url);
    }
    
    public function getLinkPlay() {
        $play_url = 'https://drive.google.com/get_video_info?docid=' . $this->file_id;
        $client = new Client();
        $response = $client->request('GET', $play_url);
        $content = $response->getBody()->getContents();
        $cookies = $response->getHeaders()['Set-Cookie'];
        $arr = [];
        parse_str($content,$arr);
        $stream_map = explode(',', $arr['fmt_stream_map']);
    
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
            ];
        }
        
        return $files;
    }
    
    public function getLinkPlay2() {
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
    
    public function getLinkStream() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $explode[1],
            CURLOPT_HEADER => true,
            CURLOPT_CONNECTTIMEOUT => 0,
            CURLOPT_TIMEOUT => 1000,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_NOBODY => true,
            CURLOPT_VERBOSE => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => array(
                'Connection: keep-alive',
                'Cookie: DRIVE_STREAM=' . $cookies['DRIVE_STREAM']
            )
        ));
    
        curl_exec($curl);
        $content_length = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($curl);
    }
    
    public function getFileId(string $url) {
        return explode('/', $url)[5];
    }
}
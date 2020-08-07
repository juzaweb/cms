<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class GoogleDrive
{
    protected $url;
    protected $file_id;
    
    public function __construct(string $url) {
        $this->url = $url;
        $this->file_id = $this->_getFileId($this->url);
    }
    
    public function getLinkPlay() {
        $response = $this->_getLinks();
        $content = $response->response;
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
    
            $file = json_encode([
                'path' => $this->url,
                'key' => $explode[0],
            ]);
            
            $files[] = (object) [
                'label' => $quality,
                'type' => 'mp4',
                'file' => route('stream.video', [
                    generate_token($quality . '.mp4'),
                    base64_encode(\Crypt::encryptString($file)),
                    $quality . '.mp4'
                ]),
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
    
    public function getFileId() {
        return $this->file_id;
    }
    
    public function getDataStream($key) {
        $response = $this->_getLinks();
        $content = $response->response;
        $cookies = $response->headers['Set-Cookie'];
        
        $drive_stream = '';
        foreach ($cookies as $cookie) {
            if (strpos($cookie, 'DRIVE_STREAM=') === 0) {
                $drive_stream = str_replace('DRIVE_STREAM=', '', $cookie);
            }
        }
        
        $arr = [];
        parse_str($content,$arr);
        $stream_map = explode(',', $arr['fmt_stream_map']);
        
        foreach ($stream_map as $file) {
            $explode = explode('|', $file);
            if ($explode[0] == $key) {
                $file_url = $explode[1];
            }
        }
        
        if (empty($file_url)) {
            return false;
        }
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $file_url,
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
                'Cookie: DRIVE_STREAM=' . $drive_stream
            )
        ));
    
        curl_exec($curl);
        $content_length = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        curl_close($curl);
    
        return [
            'content_length' => $content_length,
            'drive_stream' => $drive_stream,
            'src' => $file_url,
        ];
    }
    
    private function _getFileId(string $url) {
        return explode('/', $url)[5];
    }
    
    private function _getLinks() {
        $play_url = 'https://drive.google.com/get_video_info?docid=' . $this->file_id;
        $client = new Client();
        $response = $client->request('GET', $play_url);
        return (object) [
            'response' => $response->getBody()->getContents(),
            'headers' => $response->getHeaders(),
        ];
    }
}
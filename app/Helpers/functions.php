<?php

use App\Models\Genres;
use App\Models\Menu;
use App\Models\Sliders;
use App\Models\ThemeConfigs;
use App\Models\Types;

function json_message($message, $status = 'success') {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

function image_path($url) {
    $img = explode('uploads/', $url);
    if (isset($img[1])) {
        return $img[1];
    }
    
    return $img[0];
}

function is_url($string) {
    if (substr($string, 0, 7) === 'http://') {
        return true;
    }
    
    if (substr($string, 0, 8) === 'https://') {
        return true;
    }
    
    return false;
}

function image_url($path) {
    if (is_url($path)) {
        return $path;
    }
    
    if ($path) {
        $file_path = Storage::disk('uploads')->path($path);
        $file_url = Storage::disk('uploads')->url($path);
        
        if (file_exists($file_path)) {
            return $file_url;
        }
    }
    
    return asset('images/thumb-default.png');
}

function get_config(string $key) {
    return \App\Models\Configs::getConfig($key);
}

function copyfile_chunked($infile, $outfile) {
    $chunksize = 10 * (1024 * 1024); // 10 Megs
    
    /**
     * parse_url breaks a part a URL into it's parts, i.e. host, path,
     * query string, etc.
     */
    $parts = parse_url($infile);
    $i_handle = fsockopen($parts['host'], 80, $errstr, $errcode, 5);
    $o_handle = fopen($outfile, 'wb');
    
    if ($i_handle == false || $o_handle == false) {
        return false;
    }
    
    if (!empty($parts['query'])) {
        $parts['path'] .= '?' . $parts['query'];
    }
    
    /**
     * Send the request to the server for the file
     */
    $request = "GET {$parts['path']} HTTP/1.1\r\n";
    $request .= "Host: {$parts['host']}\r\n";
    $request .= "User-Agent: Mozilla/5.0\r\n";
    $request .= "Keep-Alive: 115\r\n";
    $request .= "Connection: keep-alive\r\n\r\n";
    fwrite($i_handle, $request);
    
    /**
     * Now read the headers from the remote server. We'll need
     * to get the content length.
     */
    $headers = array();
    while(!feof($i_handle)) {
        $line = fgets($i_handle);
        if ($line == "\r\n") break;
        $headers[] = $line;
    }
    
    /**
     * Look for the Content-Length header, and get the size
     * of the remote file.
     */
    $length = 0;
    foreach($headers as $header) {
        if (stripos($header, 'Content-Length:') === 0) {
            $length = (int)str_replace('Content-Length: ', '', $header);
            break;
        }
    }
    
    /**
     * Start reading in the remote file, and writing it to the
     * local file one chunk at a time.
     */
    $cnt = 0;
    while(!feof($i_handle)) {
        $buf = fread($i_handle, $chunksize);
        $bytes = fwrite($o_handle, $buf);
        if ($bytes == false) {
            return false;
        }
        $cnt += $bytes;
        
        /**
         * We're done reading when we've reached the conent length
         */
        if ($cnt >= $length) break;
    }
    
    fclose($i_handle);
    fclose($o_handle);
    return $cnt;
}

function full_text_wildcards($term) {
    $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
    $term = str_replace($reservedSymbols, '', $term);
    $words = explode(' ', $term);
    
    foreach ($words as $key => $word) {
        if (strlen($word) >= 1) {
            $words[$key] = '+' . $word  . '*';
        }
    }
    
    $searchTerm = implode(' ', $words);
    
    return $searchTerm;
}

function theme_config($code) {
    return ThemeConfigs::where('code', '=', $code)
        ->first();
}

function menu_info($id) {
    return Menu::where('id', '=', $id)
        ->first();
}

function genre_info($id) {
    return Genres::where('id', '=', $id)
        ->first();
}

function type_info($id) {
    return Types::where('id', '=', $id)
        ->first();
}

function theme_setting($code) {
    $config = ThemeConfigs::where('code', '=', $code)
        ->first();
    
    if ($config) {
        return json_decode($config->content);
    }
    
    return false;
}

function slider_setting($setting) {
    $slider = Sliders::where('id', '=', $setting)
        ->first();
    if ($slider) {
        return json_decode($slider->content);
    }
    
    return false;
}
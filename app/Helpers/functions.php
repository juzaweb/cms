<?php

use App\Models\Ads;
use App\Models\Countries;
use App\Models\Genres;
use App\Models\Menu;
use App\Models\Movies;
use App\Models\Sliders;
use App\Models\ThemeConfigs;
use App\Models\Types;
use Illuminate\Support\Str;

function json_message($message, $status = 'success') {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit();
}

function get_ip_client() {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        return $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    
    return request()->ip();
}

function generate_token($string) {
    $month = date('Y-m');
    $ip = get_ip_client();
    $key = 'ADAsd$#5vSD342354BCVByt&%^23vx';
    return md5($key . $month . $key) . md5($key . $ip . $string);
}

function check_token($token, $string) {
    if (generate_token($string) == $token) {
        return true;
    }
    return false;
}

function sub_words($string, int $words = 20) {
    return Str::words($string, $words);
}

function image_path($url) {
    $img = explode('uploads/', $url);
    if (isset($img[1])) {
        return $img[1];
    }
    
    return $img[0];
}

function is_url($string) {
    if (empty($string)) {
        return false;
    }
    
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
        $storage = Storage::disk('uploads');
        $file_path = $storage->path($path);
        $file_url = $storage->url($path);
        
        if (file_exists($file_path)) {
            return $file_url;
        }
    }
    
    return asset('images/thumb-default.png');
}

function logo_url($path) {
    if (empty($path)) {
        return asset('images/logo.png');
    }
    
    return image_url($path);
}

function get_config(string $key) {
    return \App\Models\Configs::getConfig($key);
}

function get_ads(string $key) {
    $ads = Ads::where('key', '=', $key)
        ->where('status', '=', 1)
        ->first(['body']);
    if (empty($ads)) {
        return false;
    }
    
    return $ads->body;
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
    $config = ThemeConfigs::where('code', '=', $code)
        ->first(['content']);
    if ($config) {
        return json_decode($config->content, true);
    }
    
    return false;
}

function menu_info($id) {
    return Menu::where('id', '=', $id)
        ->first(['id', 'name']);
}

function genre_info($id) {
    return Genres::where('id', '=', $id)
        ->first(['id', 'name']);
}

function type_info($id) {
    return Types::where('id', '=', $id)
        ->first(['id', 'name']);
}

function country_info($id) {
    return Countries::where('id', '=', $id)
        ->first(['id', 'name']);
}

function theme_setting($code) {
    $config = ThemeConfigs::where('code', '=', $code)
        ->first(['content']);
    
    if ($config) {
        return json_decode($config->content);
    }
    
    return false;
}

function slider_setting($slider_id) {
    $slider = Sliders::find($slider_id);
    if ($slider) {
        return json_decode($slider->content);
    }
    
    return false;
}

function menu_setting($menu_id) {
    try {
        $menu = Menu::find($menu_id);
        if ($menu) {
            return json_decode($menu->content);
        }
    }
    catch (Exception $exception) {
        \Log::error($exception->getMessage());
    }
    return [];
}

function genre_setting($setting) {
    $order = isset($setting->order) ? $setting->order : 'id_DESC';
    $limit = isset($setting->limit) ? intval($setting->limit) : 6;
    $ctype = isset($setting->ctype) ? intval($setting->ctype) : 1;
    $format = isset($setting->format) ? intval($setting->format) : 0;
    $order = explode('_', $order);
    $result = new stdClass();
    
    if (empty($ctype)) {
        $ctype = 1;
    }
    
    if (!in_array($order[0], ['updated_at', 'view'])) {
        $order[0] = 'id';
    }
    
    if ($order[0] == 'view') {
        $order[0] = 'views';
    }
    
    if (!in_array($order[1], ['ASC', 'DESC'])) {
        $order[1] = 'DESC';
    }
    
    $query = Movies::query();
    $query->select([
        'id',
        'name',
        'other_name',
        'short_description',
        'thumbnail',
        'slug',
        'views',
        'video_quality',
        'year',
        'genres',
        'countries',
        'tv_series',
        'current_episode',
        'max_episode',
    ]);
    
    $query->where('status', '=', 1);
    
    if ($format) {
        $query->where('tv_series', '=', $format - 1);
    }
    
    if ($ctype == 1) {
        if (@$setting->genre) {
            $query->whereRaw('find_in_set(?, genres)', [$setting->genre]);
            $result->url = route('genre', @Genres::find($setting->genre)->slug);
        }
    }
    
    if ($ctype == 2) {
        if (@$setting->type) {
            $query->where('type_id', '=', $setting->type);
            $result->url = route('type', @Types::find($setting->type)->slug);
        }
    }
    
    if ($ctype == 3) {
        if (@$setting->country) {
            $query->whereRaw('find_in_set(?, countries)', [$setting->country]);
            $result->url = route('country', @Countries::find($setting->country)->slug);
        }
    }
    
    if (empty($result->url)) {
        if ($format == 1) {
            $result->url = route('movies');
        }
    
        if ($format == 2) {
            $result->url = route('tv_series');
        }
        
        if (empty($format)) {
            $result->url = route('latest_movies');
        }
    }
    
    $query->orderBy($order[0], $order[1]);
    $query->limit($limit);
    
    $result->items = $query->get();
    $result->title = @$setting->title;
    return $result;
}

function child_genres_setting($setting) {
    try {
        $query = Genres::query();
        $query->whereIn('id', $setting);
        $query->where('status', '=', 1);
        return $query->get(['id', 'name', 'slug']);
    }
    catch (Exception $exception) {
        return [];
    }
}

function get_youtube_id($url) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    if (@$match[1]) {
        return $match[1];
    }
    return false;
}

function get_vimeo_id($url) {
    $regs = [];
    $id = '';
    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
        $id = $regs[3];
    }
    return $id;
}

function count_unread_notifications() {
    return Auth::user()->unreadNotifications()->count(['id']);
}

function get_google_drive_id(string $url) {
    return explode('/', $url)[5];
}
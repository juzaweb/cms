<?php

use Illuminate\Support\Facades\Log;

function remove_bbcode($text)
{
    /* Remove BBCode */
    $text = preg_replace('~\[img\](.*?)\[/img\]~s', '', $text);
    
    $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
    $text = preg_replace($pattern, ' ', $text);
    
    /* Remove Url */
    $text = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $text);
    
    $text = str_replace(["\n", "\t"], '', $text);
    
    return trim($text);
}

function map_crawler_params($text, $params = [])
{
    foreach ($params as $key => $param) {
        $text = str_replace('['. $key .']', $param, $text);
    }
    
    return $text;
}

function clear_markvn($str)
{
    $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace(
            "/($uni)/i",
            $nonUnicode,
            $str
        );
    }
    
    $str = strtolower(preg_replace('/[^a-zA-Z0-9\ ]/', '', $str));
    $str = preg_replace('/\s\s+/', ' ', trim($str));
    return $str;
}

function base_domain($url)
{
    if (!is_url($url)) {
        return false;
    }
    
    $domain = explode('/', $url)[2];
    $domain = str_replace('www.', '', $domain);
    
    return $domain;
}

function write_log(\Exception $exception)
{
    Log::error(implode(',', [
        'File: ' . $exception->getFile(),
        'Line: ' . $exception->getLine(),
        'Message: ' . $exception->getMessage(),
    ]));
}

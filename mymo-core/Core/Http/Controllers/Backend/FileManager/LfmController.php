<?php

namespace Mymo\Core\Http\Controllers\Backend\FileManager;

use Mymo\Core\Http\Controllers\Controller;

class LfmController extends Controller
{
    protected static $success_response = 'OK';
    
    public function __construct() {
    
    }
    
    public function show() {
        $type = $this->getType();
        if ($type == 1) {
            $mime_types = [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
            ];
        }
        else {
            $mime_types = [
                'audio/mpeg',
                'video/mp4',
                'video/mpeg',
            ];
        }
        
        return view('backend.file_manager.index', [
            'mime_types' => $mime_types
        ]);
    }
    
    public function getErrors() {
        $arr_errors = [];

        if (! extension_loaded('gd') && ! extension_loaded('imagick')) {
            array_push($arr_errors, trans('lfm.message_extension_not_found'));
        }

        if (! extension_loaded('exif')) {
            array_push($arr_errors, 'EXIF extension not found.');
        }

        if (! extension_loaded('fileinfo')) {
            array_push($arr_errors, 'Fileinfo extension not found.');
        }
        
        return $arr_errors;
    }
    
    public function error($error_type, $variables = []) {
        throw new \Exception(trans('lfm.error_' . $error_type, $variables));
    }
    
    protected function getType() {
        $type = strtolower(\request()->get('type'));
        if (in_array($type, ['image', 'images'])) {
            return 1;
        }
        
        return 2;
    }
    
    protected function getPath($url) {
        $explode = explode('uploads/', $url);
        if ($explode[1]) {
            return $explode[1];
        }
        return $url;
    }
    
    protected function isDirectory($file) {
        if (is_numeric($file)) {
            return true;
        }
        
        return false;
    }
}

<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use UniSharp\LaravelFilemanager\Lfm;
use UniSharp\LaravelFilemanager\LfmPath;

class LfmController extends Controller
{
    protected static $success_response = 'OK';
    
    public function __construct() {
    
    }
    
    public function __get($var_name)
    {
        if ($var_name === 'lfm') {
            return app(LfmPath::class);
        } elseif ($var_name === 'helper') {
            return app(Lfm::class);
        }
    }
    
    public function show(Request $request) {
        $type = strtolower($request->get('type'));
        if ($type == 'image') {
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
            array_push($arr_errors, trans('lfm.message-extension_not_found'));
        }

        if (! extension_loaded('exif')) {
            array_push($arr_errors, 'EXIF extension not found.');
        }

        if (! extension_loaded('fileinfo')) {
            array_push($arr_errors, 'Fileinfo extension not found.');
        }

        $mine_config_key = 'lfm.folder_categories.'
            . $this->helper->currentLfmType()
            . '.valid_mime';

        if (! is_array(config($mine_config_key))) {
            array_push($arr_errors, 'Config : ' . $mine_config_key . ' is not a valid array.');
        }

        return $arr_errors;
    }

    public function error($error_type, $variables = []) {
        throw new \Exception(trans('error-' . $error_type, $variables));
    }
}

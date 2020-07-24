<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Http\Controllers\Controller;
use UniSharp\LaravelFilemanager\Lfm;
use UniSharp\LaravelFilemanager\LfmPath;

class LfmController extends Controller
{
    protected static $success_response = 'OK';
    
    public function __get($var_name)
    {
        if ($var_name === 'lfm') {
            return app(LfmPath::class);
        } elseif ($var_name === 'helper') {
            return app(Lfm::class);
        }
    }
    
    public function show() {
        return view('backend.file-manager.index')
            ->withHelper($this->helper);
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
        throw new \Exception(trans('lfm.error-' . $error_type, $variables));
    }
}

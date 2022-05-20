<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Juzaweb\CMS\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    protected static $success_response = 'OK';

    public function index(Request $request)
    {
        $type = $this->getType();
        $mimeTypes = config("juzaweb.filemanager.types.{$type}.valid_mime");
        $maxSize = config("juzaweb.filemanager.types.{$type}.max_size");
        $multiChoose = $request->get('multichoose', 0);

        if (empty($mimeTypes)) {
            return abort(404);
        }

        return view('cms::backend.filemanager.index', compact(
            'mimeTypes',
            'maxSize',
            'multiChoose'
        ));
    }

    public function getErrors()
    {
        $arr_errors = [];

        if (! extension_loaded('gd')) {
            $arr_errors[] = trans('cms::filemanager.message_extension_not_found', ['name' => 'gd']);
        }

        if (! extension_loaded('imagick')) {
            $arr_errors[] = trans('cms::filemanager.message_extension_not_found', ['name' => 'imagick']);
        }

        if (! extension_loaded('exif')) {
            $arr_errors[] = trans('cms::filemanager.message_extension_not_found', ['name' => 'exif']);
        }

        if (! extension_loaded('fileinfo')) {
            $arr_errors[] = trans('cms::filemanager.message_extension_not_found', ['name' => 'fileinfo']);
        }

        return $arr_errors;
    }

    public function error($error_type, $variables = [])
    {
        throw new \Exception(trans('cms::filemanager.error_' . $error_type, $variables));
    }

    protected function getType()
    {
        $type = strtolower(request()->get('type'));

        return Str::singular($type);
    }

    protected function getPath($url)
    {
        $explode = explode('uploads/', $url);
        if (isset($explode[1])) {
            return $explode[1];
        }

        return $url;
    }

    protected function isDirectory($file)
    {
        if (is_numeric($file)) {
            return true;
        }

        return false;
    }
}

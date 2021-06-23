<?php

namespace Mymo\Backend\Http\Controllers\FileManager;

use Illuminate\Support\Facades\Storage;
use Mymo\Core\Models\Files;

class DownloadController extends FileManagerController
{
    public function getDownload()
    {
        $file = $this->getPath(request()->get('file'));
        $data = Files::where('path', '=', $file)->first(['name']);
        
        $path = Storage::disk(config('mymo.filemanager.disk'))->path($file);
        if ($data) {
            return response()->download($path, $data->name);
        }
        
        return response()->download($path);
    }
}

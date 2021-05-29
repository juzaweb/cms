<?php

namespace Mymo\FileManager\Http\Controllers\Backend\FileManager;

use Mymo\Core\Models\Files;

class DownloadController extends FileManagerController
{
    public function getDownload()
    {
        $file = $this->getPath(request()->get('file'));
        $data = Files::where('path', '=', $file)->first(['name']);
        
        $path = \Storage::disk('public')->path($file);
        if ($data) {
            return response()->download($path, $data->name);
        }
        
        return response()->download($path);
    }
}

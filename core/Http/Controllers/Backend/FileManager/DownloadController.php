<?php

namespace App\Http\Controllers\Backend\FileManager;

use App\Models\Files;

class DownloadController extends LfmController
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

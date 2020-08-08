<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Models\Files;

class DownloadController extends LfmController
{
    public function getDownload()
    {
        $file = $this->getPath(request()->get('file'));
        $data = Files::where('path', '=', $file)->first(['name']);
        
        $path = \Storage::disk('uploads')->path($file);
        if ($data) {
            return response()->download($path, $data->name);
        }
        
        return response()->download($path);
    }
}

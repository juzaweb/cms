<?php

namespace Mymo\Core\Http\Controllers\Backend\FileManager;

use Mymo\Core\Models\Files;

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

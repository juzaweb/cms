<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Models\Files;
use App\Models\Folders;

class RenameController extends LfmController
{
    public function getRename()
    {
        $file = request()->input('file');
        $new_name = request()->input('new_name');
        
        $is_directory = $this->isDirectory($file);

        if (empty($new_name)) {
            if ($is_directory) {
                return parent::error('folder-name');
            } else {
                return parent::error('file-name');
            }
        }

        if ($is_directory) {
            Folders::where('id', '=', $file)
                ->update([
                    'name' => $new_name
                ]);
        }
        else {
            $file_path = explode('uploads/', $file)[1];
            
            Files::where('path', '=', $file_path)
                ->update([
                    'name' => $new_name
                ]);
        }
        
        return parent::$success_response;
    }
}

<?php

namespace Mymo\Backend\Http\Controllers\FileManager;

use Illuminate\Http\Request;
use Mymo\Core\Models\Files;
use Mymo\Core\Models\Folder;

class DeleteController extends FileManagerController
{
    public function delete(Request $request)
    {
        $itemNames = $request->post('items');
        $errors = [];

        foreach ($itemNames as $file) {
            if (is_null($file)) {
                array_push($errors, parent::error('folder-name'));
                continue;
            }
    
            $is_directory = $this->isDirectory($file);
            if ($is_directory) {
                Folder::find($file)->deleteFolder();
            } else {
                $file_path = $this->getPath($file);
                Files::where('path', '=', $file_path)
                    ->first()
                    ->delete();
            }
        }

        if (count($errors) > 0) {
            return $errors;
        }

        return parent::$success_response;
    }
}

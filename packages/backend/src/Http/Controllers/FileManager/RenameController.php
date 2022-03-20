<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\MediaFolder;

class RenameController extends FileManagerController
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
            MediaFolder::where('id', '=', $file)
                ->update([
                    'name' => $new_name,
                ]);
        } else {
            $file_path = explode('uploads/', $file)[1];

            MediaFile::where('path', '=', $file_path)
                ->update([
                    'name' => $new_name,
                ]);
        }

        return parent::$success_response;
    }
}

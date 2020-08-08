<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Models\Folders;

class FolderController extends LfmController
{
    public function getFolders()
    {
        return view('backend.file_manager.tree')
            ->with([
                'root_folders' => [
                    (object) [
                        'name' => 'Root',
                        'url' => '',
                        'children' => [],
                        'has_next' => false,
                    ]
                ],
            ]);
    }
    
    public function getAddfolder()
    {
        $folder_name = request()->input('name');
        $parent_id = null;
        
        try {
            if ($folder_name === null || $folder_name == '') {
                return $this->error('folder-name');
            }
            
            if (Folders::folderExists($folder_name, $parent_id)) {
                return $this->error('folder-exist');
            }
            
            if (preg_match('/[^\w-]/i', $folder_name)) {
                return $this->error('folder-alnum');
            } else {
                
                $model = new Folders();
                $model->name = $folder_name;
                $model->folder_id = $parent_id;
                $model->save();
                
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return parent::$success_response;
    }
}

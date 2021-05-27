<?php

namespace Mymo\Core\Http\Controllers\Backend\FileManager;

use Mymo\Core\Models\Folders;

class FolderController extends LfmController
{
    public function getFolders()
    {
        $childrens = [];
        $folders = Folders::whereNull('folder_id')
            ->get(['id', 'name']);
        
        foreach ($folders as $folder) {
            $childrens[] = (object) [
                'name' => $folder->name,
                'url' => $folder->id,
                'children' => [],
                'has_next' => false,
            ];
        }
        
        return view('mymo_core::backend.file_manager.tree')
            ->with([
                'root_folders' => [
                    (object) [
                        'name' => 'Root',
                        'url' => '',
                        'children' => $childrens,
                        'has_next' => $childrens ? true : false,
                    ]
                ],
            ]);
    }
    
    public function getAddfolder()
    {
        $folder_name = request()->input('name');
        $parent_id = request()->input('working_dir');
        
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
                $model->type = $this->getType();
                $model->folder_id = $parent_id;
                $model->save();
                
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return parent::$success_response;
    }
}

<?php

namespace App\Http\Controllers\Backend\Filemanager;

use App\Models\Folders;

class FolderController extends LfmController
{
    public function getFolders()
    {
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });
        
        return view('backend.file-manager.tree')
            ->with([
                'root_folders' => array_map(function ($type) use ($folder_types) {
                    $path = $this->lfm->dir($this->helper->getRootFolder($type));

                    return (object) [
                        'name' => trans('lfm.title-' . $type),
                        'url' => $path->path('working_dir'),
                        'children' => $path->folders(),
                        'has_next' => ! ($type == end($folder_types)),
                    ];
                    
                }, $folder_types),
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

<?php

namespace Mymo\Backend\Http\Controllers\FileManager;

use Illuminate\Support\Facades\DB;
use Mymo\Core\Models\Folders;

class FolderController extends FileManagerController
{
    public function getFolders()
    {
        $childrens = [];
        $folders = Folders::whereNull('folder_id')
            ->where('type', '=', $this->getType())
            ->get(['id', 'name']);
        
        foreach ($folders as $folder) {
            $childrens[] = (object) [
                'name' => $folder->name,
                'url' => $folder->id,
                'children' => [],
                'has_next' => false,
            ];
        }
        
        return view('mymo::filemanager.tree')
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
    
    public function addfolder()
    {
        $folder_name = request()->input('name');
        $parent_id = request()->input('working_dir');

        if ($folder_name === null || $folder_name == '') {
            return $this->error('folder-name');
        }

        if (Folders::folderExists($folder_name, $parent_id)) {
            return $this->error('folder-exist');
        }

        if (preg_match('/[^\w-]/i', $folder_name)) {
            return $this->error('folder-alnum');
        }

        DB::beginTransaction();
        try {
            $model = new Folders();
            $model->name = $folder_name;
            $model->type = $this->getType();
            $model->folder_id = $parent_id;
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        return parent::$success_response;
    }
}

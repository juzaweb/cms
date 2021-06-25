<?php
/**
 * MYMO CMS - The Best Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/25/2021
 * Time: 11:47 PM
 */

namespace Mymo\Backend\Http\Controllers\Backend;

use Mymo\Backend\Http\Controllers\BackendController;
use Mymo\Core\Models\File;
use Mymo\Core\Models\Folder;

class MediaController extends BackendController
{
    public function index($folderId = null)
    {
        $title = trans('mymo::app.media');
        if ($folderId) {
            $this->addBreadcrumb([
                'title' => $title,
                'url' => route('admin.media'),
            ]);

            $folder = Folder::find($folderId);
            $folder->load('parent');
            $this->addBreadcrumbFolder($folder);
            $title = $folder->name;
        }



        return view('mymo::backend.media.index', [
            'fileTypes' => $this->getFileTypes(),
            'folderId' => $folderId,
            'title' => $title
        ]);
    }

    public function addFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:lfm_folder_media,id',
        ], [], [
            'name' => trans('filemanager::file-manager.folder-name'),
            'parent_id' => trans('filemanager::file-manager.parent')
        ]);

        $name = $request->post('name');
        $parentId = $request->post('parent_id');

        if ($this->folderRepository->exists([
            'name' => $name,
            'parent_id' => $parentId
        ])) {
            return $this->error(
                trans('filemanager::file-manager.errors.folder-exists')
            );
        }

        try {
            DB::beginTransaction();
            Folder::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // event

        return $this->success(trans('tadcms::app.add-folder-successfully'));
    }

    protected function getFileTypes()
    {
        return config('mymo.filemanager.types');
    }

    protected function addBreadcrumbFolder($folder)
    {
        $parent = $folder->parent;
        if ($parent) {
            $this->addBreadcrumb([
                'title' => $parent->name,
                'url' => route('admin.media.folder', $parent->id),
            ]);

            $parent->load('parent');
            if ($parent->parent) {
                $this->addBreadcrumbFolder($parent);
            }
        }
    }

    /**
     * Get files in folder
     *
     * @param Collection $sQuery
     * @return array
     */
    protected function getFiles($sQuery)
    {
        $result = [];
        $fileIcon = $this->getFileIcon();
        $query = File::whereFolderId($this->folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $files = $query->get();
        foreach ($files as $row) {
            $fileUrl = FileManager::url($row->path);
            $thumb = FileManager::isImage($row) ? $fileUrl : null;
            $icon = isset($fileIcon[strtolower($row->extension)]) ?
                $fileIcon[strtolower($row->extension)] : 'fa-file-o';

            $result[] = (object) [
                'id' => $row->id,
                'name' => $row->name,
                'url' => $fileUrl,
                'size' => $row->size,
                'updated' => strtotime($row->updated_at),
                'path' => $row->path,
                'time' => (string) $row->created_at,
                'type' => $row->type,
                'icon' => $icon,
                'thumb' => $thumb,
                'is_file' => true
            ];
        }

        return $result;
    }

    /**
     * Get directories in folder
     *
     * @param Collection $sQuery
     * @return array
     */
    protected function getDirectories($sQuery)
    {
        $result = [];
        $query = Folder::whereParentId($this->folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $directories = $query->get();
        foreach ($directories as $row) {
            $result[] = (object) [
                'id' => $row->id,
                'name' => $row->name,
                'url' => '',
                'size' => '',
                'updated' => strtotime($row->updated_at),
                'path' => $row->id,
                'time' => (string) $row->created_at,
                'type' => $row->type,
                'icon' => 'fa-folder-o',
                'thumb' => asset('tadcms/filemanager/images/folder.png'),
                'is_file' => false
            ];
        }

        return $result;
    }
}
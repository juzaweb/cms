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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $query = collect(request()->query());
        $mediaItems = array_merge(
            $this->getDirectories($query, $folderId),
            $this->getFiles($query, $folderId)
        );

        return view('mymo::backend.media.index', [
            'fileTypes' => $this->getFileTypes(),
            'folderId' => $folderId,
            'mediaItems' => $mediaItems,
            'title' => $title
        ]);
    }

    public function addFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'folder_id' => 'nullable|exists:folders,id',
        ], [], [
            'name' => trans('mymo::filemanager.folder-name'),
            'folder_id' => trans('mymo::filemanager.parent')
        ]);

        $name = $request->post('name');
        $parentId = $request->post('folder_id');

        if (Folder::folderExists($name, $parentId)) {
            return $this->error([
                'message' => trans('mymo::filemanager.errors.folder-exists')
            ]);
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

        return $this->success(trans('mymo::filemanager.add-folder-successfully'));
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
     * @param integer $folderId
     * @return array
     */
    protected function getFiles($sQuery, $folderId)
    {
        $result = [];
        $fileIcon = $this->getFileIcon();
        $query = File::whereFolderId($folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $files = $query->get();
        foreach ($files as $row) {
            $fileUrl = upload_url($row->path);
            $thumb = $row->isImage($row) ? $fileUrl : null;
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
     * @param integer $folderId
     * @return array
     */
    protected function getDirectories($sQuery, $folderId)
    {
        $result = [];
        $query = Folder::whereFolderId($folderId);

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
                'thumb' => asset('mymo/filemanager/images/folder.png'),
                'is_file' => false
            ];
        }

        return $result;
    }

    protected function getFileIcon()
    {
        return [
            'pdf'  => 'fa-file-pdf-o',
            'doc'  => 'fa-file-word-o',
            'docx' => 'fa-file-word-o',
            'xls'  => 'fa-file-excel-o',
            'xlsx' => 'fa-file-excel-o',
            'rar'  => 'fa-file-archive-o',
            'zip'  => 'fa-file-archive-o',
            'gif'  => 'fa-file-image-o',
            'jpg'  => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'png'  => 'fa-file-image-o',
            'ppt'  => 'fa-file-powerpoint-o',
            'pptx' => 'fa-file-powerpoint-o',
            'mp4'  => 'fa-file-video-o',
            'mp3'  => 'fa-file-video-o',
            'jfif' => 'fa-file-image-o',
            'txt'  => 'fa-file-text-o',
        ];
    }
}
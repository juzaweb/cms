<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\MediaFolder;
use Inertia\Inertia;

class MediaController extends BackendController
{
    public function index(Request $request, $folderId = null)
    {
        $title = trans('cms::app.media');
        $type = $request->get('type', 'image');

        if ($folderId) {
            $this->addBreadcrumb([
                'title' => $title,
                'url' => route('admin.media.index'),
            ]);

            $folder = MediaFolder::find($folderId);
            $folder->load('parent');
            $this->addBreadcrumbFolder($folder);
            $title = $folder->name;
        }

        $query = collect(request()->query());
        $mediaItems = array_merge(
            $this->getDirectories($query, $folderId),
            $this->getFiles($query, $folderId)
        );

        $maxSize = config("juzaweb.filemanager.types.{$type}.max_size");
        $mimeTypes = config("juzaweb.filemanager.types.{$type}.valid_mime");
        
        return Inertia::render(
            'Media',
            [
                'fileTypes' => $this->getFileTypes(),
                'folderId' => $folderId,
                'mediaItems' => $mediaItems,
                'title' => $title,
                'mimeTypes' => $mimeTypes,
                'type' => $type,
                'maxSize' => $maxSize
            ]
        );
    }

    public function addFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'folder_id' => 'nullable|exists:media_folders,id',
        ], [], [
            'name' => trans('cms::filemanager.folder-name'),
            'folder_id' => trans('cms::filemanager.parent'),
        ]);

        $name = $request->post('name');
        $parentId = $request->post('folder_id');

        if (MediaFolder::folderExists($name, $parentId)) {
            return $this->error([
                'message' => trans('cms::filemanager.folder-exists'),
            ]);
        }

        try {
            DB::beginTransaction();
            MediaFolder::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        // event

        return $this->success(trans('cms::filemanager.add-folder-successfully'));
    }

    protected function getFileTypes()
    {
        return config('juzaweb.filemanager.types');
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
     * @param \Illuminate\Support\Collection $sQuery
     * @param int $folderId
     * @return array
     */
    protected function getFiles($sQuery, $folderId)
    {
        $result = [];
        $fileIcon = $this->getFileIcon();
        $query = MediaFile::whereFolderId($folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $files = $query->get();
        foreach ($files as $row) {
            $fileUrl = upload_url($row->path);
            $thumb = $row->isImage() ? $fileUrl : null;
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
                'is_file' => true,
            ];
        }

        return $result;
    }

    /**
     * Get directories in folder
     *
     * @param \Illuminate\Support\Collection $sQuery
     * @param int $folderId
     * @return array
     */
    protected function getDirectories($sQuery, $folderId)
    {
        $result = [];
        $query = MediaFolder::whereFolderId($folderId);

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
                'thumb' => asset('jw-styles/juzaweb/images/folder.png'),
                'is_file' => false,
            ];
        }

        return $result;
    }

    protected function getFileIcon()
    {
        return [
            'pdf' => 'fa-file-pdf-o',
            'doc' => 'fa-file-word-o',
            'docx' => 'fa-file-word-o',
            'xls' => 'fa-file-excel-o',
            'xlsx' => 'fa-file-excel-o',
            'rar' => 'fa-file-archive-o',
            'zip' => 'fa-file-archive-o',
            'gif' => 'fa-file-image-o',
            'jpg' => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'png' => 'fa-file-image-o',
            'ppt' => 'fa-file-powerpoint-o',
            'pptx' => 'fa-file-powerpoint-o',
            'mp4' => 'fa-file-video-o',
            'mp3' => 'fa-file-video-o',
            'jfif' => 'fa-file-image-o',
            'txt' => 'fa-file-text-o',
        ];
    }
}

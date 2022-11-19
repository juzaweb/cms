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

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Events\AddFolderSuccess;
use Juzaweb\Backend\Http\Requests\Media\AddFolderRequest;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\MediaFolder;

class MediaController extends BackendController
{
    public function index(Request $request, $folderId = null): View
    {
        $title = trans('cms::app.media');
        $type = $request->get('type', 'image');

        if ($folderId) {
            $this->addBreadcrumb(
                [
                    'title' => $title,
                    'url' => route('admin.media.index'),
                ]
            );

            $folder = MediaFolder::find($folderId);
            $folder->load('parent');
            $this->addBreadcrumbFolder($folder);
            $title = $folder->name;
        }

        $query = collect(request()->query());
        $mediaFolders = $this->getDirectories($query, $folderId);
        $mediaFiles = $this->getFiles($query, 40 - $mediaFolders->count(), $folderId);

        $maxSize = config("juzaweb.filemanager.types.{$type}.max_size");
        $mimeTypes = config("juzaweb.filemanager.types.{$type}.valid_mime");
        if (empty($mimeTypes)) {
            $mimeTypes = config("juzaweb.filemanager.types.file.valid_mime");
        }

        return view(
            'cms::backend.media.index',
            [
                'fileTypes' => $this->getFileTypes(),
                'folderId' => $folderId,
                'mediaFolders' => $mediaFolders,
                'mediaFiles' => $mediaFiles,
                'title' => $title,
                'mimeTypes' => $mimeTypes,
                'type' => $type,
                'maxSize' => $maxSize,
            ]
        );
    }

    public function addFolder(AddFolderRequest $request): JsonResponse|RedirectResponse
    {
        DB::beginTransaction();
        try {
            $folder = MediaFolder::create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        event(new AddFolderSuccess($folder));

        return $this->success(
            trans('cms::filemanager.add-folder-successfully')
        );
    }

    protected function getFileTypes()
    {
        return config('juzaweb.filemanager.types');
    }

    protected function addBreadcrumbFolder($folder)
    {
        $parent = $folder->parent;
        if ($parent) {
            $this->addBreadcrumb(
                [
                    'title' => $parent->name,
                    'url' => route('admin.media.folder', $parent->id),
                ]
            );

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
     * @param int $limit
     * @param int|null $folderId
     * @return LengthAwarePaginator
     */
    protected function getFiles(Collection $sQuery, int $limit = 40, ?int $folderId = null): LengthAwarePaginator
    {
        $query = MediaFile::whereFolderId($folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $query->orderBy('id', 'DESC');

        return $query->paginate($limit);
    }

    /**
     * Get directories in folder
     *
     * @param Collection $sQuery
     * @param int|null $folderId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getDirectories(Collection $sQuery, ?int $folderId): \Illuminate\Database\Eloquent\Collection
    {
        $query = MediaFolder::whereFolderId($folderId);

        return $query->get();
    }
}

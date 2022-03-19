<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Illuminate\Support\Facades\Storage;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\MediaFolder;

class ItemsController extends FileManagerController
{
    public function getItems()
    {
        $file_type = $this->getType();
        $currentPage = self::getCurrentPageFromRequest();
        $perPage = 15;

        $working_dir = request()->get('working_dir');

        $folders = MediaFolder::where('folder_id', '=', $working_dir)
            ->where('type', '=', $file_type)
            ->orderBy('name', 'ASC')
            ->get(['id', 'name']);
        $files = MediaFile::where('folder_id', '=', $working_dir)
            ->where('type', '=', $file_type)
            ->orderBy('id', 'DESC')
            ->paginate($perPage);

        $storage = Storage::disk(config('juzaweb.filemanager.disk'));
        $items = [];
        foreach ($folders as $folder) {
            $items[] = [
                'icon' => 'fa-folder-o',
                'is_file' => false,
                'is_image' => false,
                'name' => $folder->name,
                'thumb_url' => asset('jw-styles/juzaweb/styles/images/folder.png'),
                'time' => false,
                'url' => $folder->id,
            ];
        }

        foreach ($files as $file) {
            $items[] = [
                'icon' => $file->type == 'image' ? 'fa-image' : 'fa-file',
                'is_file' => true,
                'path' => $file->path,
                'is_image' => $file->type == 1 ? true : false,
                'name' => $file->name,
                'thumb_url' => $file->type == 'image' ? $storage->url($file->path) : null,
                'time' => strtotime($file->created_at),
                'url' => $storage->url($file->path),
            ];
        }

        return [
            'items' => $items,
            'paginator' => [
                'current_page' => $currentPage,
                'total' => count($items),
                'per_page' => $perPage,
            ],
            'display' => 'grid',
            'working_dir' => $working_dir,
        ];
    }

    public function move()
    {
        $items = request('items');
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });

        return view('filemanager::.move')
            ->with([
                'root_folders' => array_map(function ($type) use ($folder_types) {
                    $path = $this->lfm->dir($this->helper->getRootFolder($type));

                    return (object) [
                        'name' => trans('cms::filemanager.title_' . $type),
                        'url' => $path->path('working_dir'),
                        'children' => $path->folders(),
                        'has_next' => ! ($type == end($folder_types)),
                    ];
                }, $folder_types),
            ])
            ->with('items', $items);
    }

    public function domove()
    {
        $target = $this->helper->input('goToFolder');
        $items = $this->helper->input('items');

        foreach ($items as $item) {
            $old_file = $this->lfm->pretty($item);
            $is_directory = $old_file->isDirectory();

            if ($old_file->hasThumb()) {
                $new_file = $this->lfm->setName($item)->thumb()->dir($target);
                if ($is_directory) {
                    event(new FolderIsMoving($old_file->path(), $new_file->path()));
                } else {
                    event(new FileIsMoving($old_file->path(), $new_file->path()));
                }
                $this->lfm->setName($item)->thumb()->move($new_file);
            }
            $new_file = $this->lfm->setName($item)->dir($target);
            $this->lfm->setName($item)->move($new_file);
            if ($is_directory) {
                event(new FolderWasMoving($old_file->path(), $new_file->path()));
            } else {
                event(new FileWasMoving($old_file->path(), $new_file->path()));
            }
        };

        return parent::$success_response;
    }

    private static function getCurrentPageFromRequest()
    {
        $currentPage = (int) request()->get('page', 1);
        $currentPage = $currentPage < 1 ? 1 : $currentPage;

        return $currentPage;
    }
}

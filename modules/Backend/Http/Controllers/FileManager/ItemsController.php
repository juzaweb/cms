<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Illuminate\Http\Request;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\MediaFolder;
use Juzaweb\CMS\Facades\Facades;

class ItemsController extends FileManagerController
{
    public function getItems(Request $request): array
    {
        $type = $this->getType();
        $extensions = $this->getTypeExtensions($type);
        $currentPage = self::getCurrentPageFromRequest();
        $perPage = 15;

        $workingDir = $request->get('working_dir');
        $disk = $request->get('disk') ?? config('juzaweb.filemanager.disk');

        $folders = collect([]);
        if ($currentPage == 1) {
            $folders = MediaFolder::where('folder_id', '=', $workingDir)
                ->where('disk', '=', $disk)
                ->orderBy('name', 'ASC')
                ->get(['id', 'name']);
        }

        $query = MediaFile::where('folder_id', '=', $workingDir)
            ->where('disk', '=', $disk)
            ->whereIn('extension', $extensions)
            ->orderBy('id', 'DESC');

        $totalFiles = $query->count(['id']);
        $files = $query->paginate($perPage - $folders->count());

        $items = [];
        foreach ($folders as $folder) {
            $items[] = [
                'icon' => 'fa-folder-o',
                'is_file' => false,
                'is_image' => false,
                'name' => $folder->name,
                'thumb_url' => asset('jw-styles/juzaweb/images/folder.png'),
                'time' => false,
                'url' => $folder->id,
                'path' => $folder->id,
            ];
        }

        foreach ($files as $file) {
            $items[] = [
                'icon' => $file->type == 'image' ? 'fa-image' : 'fa-file',
                'is_file' => true,
                'path' => $file->path,
                'is_image' => $file->type == 'image',
                'name' => $file->name,
                'thumb_url' => $file->type == 'image' ? upload_url($file->path) : null,
                'time' => strtotime($file->created_at),
                'url' => upload_url($file->path),
            ];
        }

        return [
            'items' => $items,
            'paginator' => [
                'current_page' => $currentPage,
                'total' => $totalFiles + $folders->count(),
                'per_page' => $perPage,
            ],
            'display' => 'grid',
            'working_dir' => $workingDir,
        ];
    }

    public function move()
    {
        $items = request('items');
        $folder_types = array_filter(
            ['user', 'share'],
            function ($type) {
                return $this->helper->allowFolderType($type);
            }
        );

        return view('filemanager::.move')
            ->with(
                [
                'root_folders' => array_map(
                    function ($type) use ($folder_types) {
                        $path = $this->lfm->dir($this->helper->getRootFolder($type));

                        return (object) [
                            'name' => trans('cms::filemanager.title_' . $type),
                            'url' => $path->path('working_dir'),
                            'children' => $path->folders(),
                            'has_next' => ! ($type == end($folder_types)),
                        ];
                    },
                    $folder_types
                ),
                ]
            )
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

    protected function getTypeExtensions(string $type)
    {
        $extensions = config("juzaweb.filemanager.types.{$type}.extensions");
        if (empty($extensions)) {
            $extensions = match ($type) {
                'file' => Facades::defaultFileExtensions(),
                'image' => Facades::defaultImageExtensions(),
            };
        }

        return $extensions;
    }

    private static function getCurrentPageFromRequest()
    {
        $currentPage = (int) request()->get('page', 1);
        return max($currentPage, 1);
    }
}

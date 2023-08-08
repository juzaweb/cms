<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MediaFileCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        $fileIcon = $this->getFileIcon();

        return $this->collection->map(
            function ($item) use ($fileIcon) {
                $fileUrl = upload_url($item->path);
                $thumb = $item->isImage() ? $fileUrl : null;
                $icon = $fileIcon[strtolower($item->extension)] ?? 'fa-file-o';

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'url' => $fileUrl,
                    'size' => $item->size,
                    'updated' => strtotime($item->updated_at),
                    'path' => $item->path,
                    'time' => (string) $item->created_at,
                    'type' => $item->type,
                    'icon' => $icon,
                    'thumb' => $thumb,
                    'is_file' => true,
                ];
            }
        )->toArray();
    }

    protected function getFileIcon(): array
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

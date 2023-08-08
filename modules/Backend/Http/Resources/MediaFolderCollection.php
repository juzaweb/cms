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

class MediaFolderCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return $this->collection->map(
            function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'url' => '',
                    'size' => '',
                    'updated' => strtotime($item->updated_at),
                    'path' => $item->id,
                    'time' => (string) $item->created_at,
                    'type' => $item->type,
                    'icon' => 'fa-folder-o',
                    'thumb' => asset('jw-styles/juzaweb/images/folder.png'),
                    'is_file' => false,
                ];
            }
        )->toArray();
    }
}

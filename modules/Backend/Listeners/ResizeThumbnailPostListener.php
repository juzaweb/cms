<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Listeners;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Juzaweb\Backend\Events\AfterPostSave;

class ResizeThumbnailPostListener
{
    public function handle(AfterPostSave $event): void
    {
        if (empty($event->post->thumbnail) || is_url($event->post->thumbnail)) {
            return;
        }

        $resize = get_config('auto_resize_thumbnail')[$event->post->type] ?? false;
        $size = get_thumbnail_size($event->post->type);
        if (empty($resize) || empty($size)) {
            return;
        }

        if (has_media_image_size($event->post->thumbnail, "{$size['width']}x{$size['height']}")) {
            return;
        }

        $img = Image::make(Storage::disk(config('juzaweb.filemanager.disk'))->path($event->post->thumbnail));
        $img->fit($size['width'], $size['height']);
        $img->save(
            get_media_image_with_size(
                $event->post->thumbnail,
                "{$size['width']}x{$size['height']}",
                'path'
            ),
            100
        );
    }
}

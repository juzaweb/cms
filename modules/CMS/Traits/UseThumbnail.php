<?php

namespace Juzaweb\CMS\Traits;

trait UseThumbnail
{
    public function getThumbnail($thumb = true)
    {
        if ($this->resize) {
            if ($thumb) {
                return upload_url($this->thumbnail);
            }

            return upload_url(str_replace('thumbs/', '', $this->thumbnail));
        }

        return upload_url($this->thumbnail);
    }

    protected function resizeThumbnail($thumbnail)
    {
        if (! isset($this->resize) || empty($this->resize)) {
            return $thumbnail;
        }

        $thumb_path = $this->getPathThumbnail($thumbnail);
        list($cw, $ch, $type, $attr) = getimagesize($thumb_path);
        list($w, $h) = explode('x', $this->resize);

        if ($cw == $w && $ch == $h) {
            return $thumbnail;
        }

        if (file_exists($thumb_path)) {
            $width = \Image::make($thumb_path)->width();

            if ($width > $w) {
                $new_file_path = $this->getDirPathThumbnail($thumbnail) . '/thumbs/';

                if (! is_dir($new_file_path)) {
                    mkdir($new_file_path);
                }

                $new_file_path .= $this->getFileNameThumbnail($thumbnail);
                $img = \Image::make($thumb_path);
                $img->fit($w, $h);
                $img->save($new_file_path, 90);

                return $new_file_path;
            }

            return $thumbnail;
        }

        return null;
    }

    protected function getFileNameThumbnail($thumbnail)
    {
        return explode('/', $thumbnail)[count(explode('/', $thumbnail)) - 1];
    }

    protected function getDirPathThumbnail($thumbnail)
    {
        $path = $this->getPathThumbnail($thumbnail);
        $file_name = $this->getFileNameThumbnail($thumbnail);

        return str_replace('/' . $file_name, '', $path);
    }

    protected function getPathThumbnail($thumbnail)
    {
        return \Storage::disk('public')->path($thumbnail);
    }

    protected function cutPathThumbnail($thumbnail)
    {
        if ($thumbnail) {
            $upload_path = \Storage::disk('public')->path('');

            return str_replace($upload_path, '', $thumbnail);
        }

        return null;
    }
}

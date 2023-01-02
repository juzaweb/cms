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
}

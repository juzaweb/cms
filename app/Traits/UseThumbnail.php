<?php

namespace App\Traits;

trait UseThumbnail {
    
    public function getThumbnail() {
        return image_url($this->thumbnail);
    }
    
    public function createThumbnail($thumbnail = null) {
        if ($thumbnail) {
            $this->thumbnail = explode('uploads', $thumbnail)[1];
        }
    }
    
}
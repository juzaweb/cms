<?php

namespace App\Traits;

trait UseThumbnail {
    
    public static function bootUseThumbnail()
    {
        $thumbnail = request()->post('thumbnail');
        static::saving(function ($model) use ($thumbnail) {
            $model->thumbnail = $model->generateThumbnail($thumbnail);
        });
    }
    
    public function getThumbnail() {
        return image_url($this->thumbnail);
    }
    
    protected function generateThumbnail($thumbnail) {
        if ($thumbnail) {
            $upload_url = \Storage::disk('uploads')->url('/');
            return str_replace($upload_url, '', $thumbnail);
        }
        
        return null;
    }
    
}
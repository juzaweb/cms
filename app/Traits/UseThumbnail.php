<?php

namespace App\Traits;

trait UseThumbnail {
    
    public static function bootUseThumbnail()
    {
        $thumbnail = request()->post('thumbnail');
        static::saving(function ($model) use ($thumbnail) {
            if ($thumbnail) {
                if ($model->resize) {
                    $thumbnail = $model->resizeThumbnail($thumbnail, $model->resize);
                }
                
                $model->thumbnail = $model->cutPathThumbnail($thumbnail);
            }
        });
    }
    
    public function getThumbnail($thumb = true) {
        if ($this->resize) {
            if ($thumb) {
                return image_url($this->thumbnail);
            }
            
            return image_url(str_replace('thumbs/', '', $this->thumbnail));
        }
        
        return image_url($this->thumbnail);
    }
    
    protected function resizeThumbnail($thumbnail, $resize_size) {
        $thumb_path = $this->getPathThumbnail($thumbnail);
        if (file_exists($thumb_path)) {
            $resize_size = explode('x', $resize_size);
            $w = $resize_size[0];
            $h = $resize_size[1];
            $new_file_path = $this->getDirPathThumbnail($thumbnail) . '/thumbs/';
            
            if (!is_dir($new_file_path)) {
                mkdir($new_file_path);
            }
            
            $new_file_path .= $this->getFileNameThumbnail($thumbnail);
            $img = \Image::make($thumb_path);
            $img->fit($w, $h);
            $img->save($new_file_path, 90);
            return $new_file_path;
        }
        
        return null;
    }
    
    protected function getFileNameThumbnail($thumbnail) {
        return explode('/', $thumbnail)[count(explode('/', $thumbnail)) - 1];
    }
    
    protected function getDirPathThumbnail($thumbnail) {
        $path = $this->getPathThumbnail($thumbnail);
        $file_name = $this->getFileNameThumbnail($thumbnail);
        return str_replace('/' . $file_name, '', $path);
    }
    
    protected function getPathThumbnail($thumbnail) {
        return \Storage::disk('uploads')->path($thumbnail);
    }
    
    protected function cutPathThumbnail($thumbnail) {
        if ($thumbnail) {
            $upload_path = \Storage::disk('uploads')->path('');
            return str_replace($upload_path, '', $thumbnail);
        }
        
        return null;
    }
    
}
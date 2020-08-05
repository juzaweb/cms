<?php

namespace App\Traits;

use App\Models\Files;
use Illuminate\Support\Str;

trait UseThumbnail {
    
    public static function bootUseThumbnail()
    {
        $thumbnail = request()->post('thumbnail');
        static::saving(function ($model) use ($thumbnail) {
            if ($thumbnail) {
                if (is_url($thumbnail)) {
                    $thumbnail = $model->downloadThumbnail($thumbnail);
                }
                
                $model->resizeThumbnail($thumbnail);
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
    
    protected function downloadThumbnail($thumbnail) {
        $data['name'] = $this->getFileNameThumbnail($thumbnail);
        $slip = explode('.', $data['name']);
        $data['extension'] = $slip[count($slip) - 1];
        $file_name = str_replace('.' . $data['extension'], '', $data['name']);
        $new_file = $file_name . '-' . Str::random(10) . '-'. time() .'.' . $data['extension'];
        
        try {
            $new_dir = \Storage::disk('uploads')->path(date('Y/m/d'));
            if (!is_dir($new_dir)) {
                \File::makeDirectory($new_dir, 0775, true);
            }
            
            $get_file = file_put_contents($new_dir . $new_file, file_get_contents($thumbnail));
            if ($get_file) {
                $data['path'] = date('Y/m/d') .'/'. $new_file;
                $model = new Files();
                $model->fill($data);
                $model->type = 1;
                $model->mime_type = \Storage::disk('uploads')
                    ->mimeType($data['path']);
                $model->user_id = \Auth::id();
                $model->save();
                
                return $data['path'];
            }
        }
        catch (\Exception $exception) {
            return false;
        }
        
        return false;
    }
    
    protected function resizeThumbnail($thumbnail, $resize_size) {
        if (!isset($this->resize) || empty($this->resize)) {
            return null;
        }
        
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
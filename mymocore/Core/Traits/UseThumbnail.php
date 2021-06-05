<?php

namespace Mymo\Core\Traits;

use Mymo\Core\Models\Files;
use Illuminate\Support\Str;

trait UseThumbnail
{
    
    public static function bootUseThumbnail()
    {
        $thumbnail = request()->post('thumbnail');
        static::saving(function ($model) use ($thumbnail) {
            if (empty($thumbnail)) {
                $thumbnail = $model->thumbnail;
            }
            
            if ($thumbnail) {
                if (is_url($thumbnail)) {
                    $thumbnail = $model->downloadThumbnail($thumbnail);
                }
                
                $thumbnail = $model->resizeThumbnail($thumbnail);
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
            $new_dir = \Storage::disk('public')->path(date('Y/m/d'));
            if (!is_dir($new_dir)) {
                \File::makeDirectory($new_dir, 0775, true);
            }
            
            $get_file = file_put_contents($new_dir . $new_file, file_get_contents($thumbnail));
            if ($get_file) {
                $data['path'] = date('Y/m/d') .'/'. $new_file;
                $model = new Files();
                $model->fill($data);
                $model->type = 1;
                $model->mime_type = \Storage::disk('public')
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
    
    protected function resizeThumbnail($thumbnail) {
        if (!isset($this->resize) || empty($this->resize)) {
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
    
                if (!is_dir($new_file_path)) {
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
    
    protected function getFileNameThumbnail($thumbnail) {
        return explode('/', $thumbnail)[count(explode('/', $thumbnail)) - 1];
    }
    
    protected function getDirPathThumbnail($thumbnail) {
        $path = $this->getPathThumbnail($thumbnail);
        $file_name = $this->getFileNameThumbnail($thumbnail);
        return str_replace('/' . $file_name, '', $path);
    }
    
    protected function getPathThumbnail($thumbnail) {
        return \Storage::disk('public')->path($thumbnail);
    }
    
    protected function cutPathThumbnail($thumbnail) {
        if ($thumbnail) {
            $upload_path = \Storage::disk('public')->path('');
            return str_replace($upload_path, '', $thumbnail);
        }
        
        return null;
    }
}

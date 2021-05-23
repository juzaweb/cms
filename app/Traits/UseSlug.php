<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UseSlug {
    
    public static function bootUseSlug()
    {
        static::saving(function ($model) {
            $model->slug = $model->generateSlug($model->name ?: $model->title);
        });
    }
    
    protected function generateSlug($string) {
        $slug = request()->post('slug');
        
        if ($slug) {
            $slug = substr($slug, 0, 70);
            $slug = Str::slug($slug);
        }
        else {
            $slug = substr($string, 0, 70);
            $slug = Str::slug($slug);
        }
        
        $count = self::where('id', '!=', $this->id)
            ->where('slug', 'like', $slug . '%')
            ->count();
    
        if ($count > 0) {
            $slug .= '-'. ($count + 1);
        }
        
        return $slug;
    }
    
}
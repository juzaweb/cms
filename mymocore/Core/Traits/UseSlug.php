<?php

namespace Mymo\Core\Traits;

use Illuminate\Support\Str;

trait UseSlug {
    public static function bootUseSlug()
    {
        static::saving(function ($model) {
            $model->slug = $model->generateSlug();
        });
    }

    public function getDisplayName()
    {
        if (empty($this->fieldName)) {
            return $this->name ?? $this->title;
        }

        return $this->{$this->fieldName};
    }

    protected function generateSlug()
    {
        $string = request()->post('slug');
        if (empty($string)) {
            $string = $this->getDisplayName();
        }

        $slug = substr($string, 0, 70);
        $slug = Str::slug($slug);
        
        $row = self::where('id', '!=', $this->id)
            ->where('slug', 'like', $slug . '%')
            ->orderBy('slug', 'DESC')
            ->first(['slug']);
    
        if ($row) {
            $split = explode('-', $row->slug);
            $last = (int) $split[count($split) - 1];
            $slug = $slug . '-'. ($last + 1);
        }
        
        return $slug;
    }
}

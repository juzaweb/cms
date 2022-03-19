<?php

namespace Juzaweb\Traits;

use Illuminate\Support\Str;

trait UseSlug
{
    public static function bootUseSlug()
    {
        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateSlug();
            }
        });
    }

    public static function findBySlug($slug)
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->first();
    }

    public static function findBySlugOrFail($slug)
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->firstOrFail();
    }

    public function getDisplayName()
    {
        if (empty($this->fieldName)) {
            return $this->name ? $this->name : $this->title;
        }

        return $this->{$this->fieldName};
    }

    public function generateSlug($string = null)
    {
        if (empty($string)) {
            $string = $this->getDisplayName();
        }

        $slug = sub_char($string, 70, '');
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

        $this->slug = $slug;

        return $slug;
    }
}

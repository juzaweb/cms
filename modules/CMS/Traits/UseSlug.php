<?php

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Str;

trait UseSlug
{
    public static function bootUseSlug(): void
    {
        static::saving(
            function ($model) {
                if (empty($model->slug)) {
                    $model->slug = $model->generateSlug();
                }
            }
        );
    }

    public static function findBySlug($slug, $column = ['*']): ?self
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->first($column);
    }

    public static function findBySlugOrFail($slug): self
    {
        return self::query()
            ->where('slug', '=', $slug)
            ->firstOrFail();
    }

    public function getDisplayName()
    {
        if (empty($this->fieldName)) {
            return $this->name ?: $this->title;
        }

        return $this->{$this->fieldName};
    }

    public function generateSlug($string = null): string
    {
        if (empty($string)) {
            if ($slug = request()->input('slug')) {
                $string = $slug;
            } elseif (isset($this->slug)) {
                $string = $this->slug;
            } else {
                $string = $this->getDisplayName();
            }
        }

        $baseSlug = Str::substr($string, 0, 70);
        $baseSlug = Str::slug($baseSlug);

        $i = 1;
        $slug = $baseSlug;
        do {
            $row = self::where('id', '!=', $this->id)
                ->where('slug', '=', $slug)
                ->orderBy('slug', 'DESC')
                ->first(['slug']);

            if ($row) {
                $slug = $baseSlug . '-' . $i;
            }

            $i++;
        } while ($row);

        $this->slug = $slug;


        return $slug;
    }
}

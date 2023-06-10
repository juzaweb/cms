<?php

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Str;

trait UseMetaSeo
{
    public static function bootUseMetaSeo()
    {
        $meta_title = request()->post('meta_title');
        $meta_description = request()->post('meta_description');
        $keywords = request()->post('keywords');

        static::saving(function ($model) use ($meta_title, $meta_description, $keywords) {
            $model->meta_title = $model->generateMetaTitle($meta_title);
            $model->meta_description = $model->generateMetaDescription($meta_description);
            $model->keywords = $keywords;
        });
    }

    protected function generateMetaTitle($string)
    {
        if ($string) {
            return $this->generateString($string, 15, 70);
        }

        return $this->generateString($this->name ?: $this->title, 15, 70);
    }

    protected function generateMetaDescription($string)
    {
        $string = strip_tags($string);
        if ($string) {
            return $this->generateString($string, 55, 300);
        }

        return $this->generateString($this->content ?: $this->description, 55, 300);
    }

    protected function generateString($string, $words, $max_length)
    {
        $string = strip_tags($string);
        while (strlen($string) > $max_length) {
            $string = Str::words($string, $words);
            $words--;
        }

        return $string;
    }
}

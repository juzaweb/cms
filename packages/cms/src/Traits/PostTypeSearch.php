<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Juzaweb\Models\Search;

trait PostTypeSearch
{
    public static function bootPostTypeSearch()
    {
        static::saved(function ($model) {
            $model->refresh();

            Search::updateOrCreate([
                'post_type' => $model->getPostType('key'),
                'post_id' => $model->id,
            ], [
                'title' => $model->title,
                'description' => str_words_length($model->description, 100, 250),
                'slug' => $model->slug,
                'status' => $model->status,
            ]);
        });

        static::deleted(function ($model) {
            Search::where([
                'post_type' => $model->getPostType('key'),
                'post_id' => $model->id,
            ])->delete();
        });
    }
}

<?php

namespace Juzaweb\Seo\Listeners;

use Illuminate\Support\Arr;
use Juzaweb\Backend\Events\AfterPostSave;
use Juzaweb\Seo\Models\SeoMeta;

class SaveSeoMetaPost
{
    public function handle(AfterPostSave $event)
    {
        $data = $event->data;

        $title = Arr::get($data, 'meta_title');
        $description = Arr::get($data, 'meta_description');

        if (empty($title) && empty($description)) {
            return;
        }

        SeoMeta::updateOrCreate([
            'object_type' => 'posts',
            'object_id' => $event->post->id,
        ], [
            'meta_title' => $title,
            'meta_description' => $description,
        ]);
    }
}

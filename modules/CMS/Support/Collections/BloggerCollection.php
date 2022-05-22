<?php

namespace Juzaweb\CMS\Support\Collections;

use Illuminate\Support\Arr;

class BloggerCollection
{
    public function getCollection($filePath)
    {
        $xmlObject = simplexml_load_file($filePath);
        $json = json_encode($xmlObject);
        $data = json_decode($json, true);
        $result = [];

        $data = collect(Arr::get($data, 'entry', []))->filter(
            function ($item) {
                return (strpos($item['id'], 'post-')
                    && $item['author']['name'] != 'Unknown'
                    && strpos($item['category']['@attributes']['term'] ?? '', 'kind#comment') === false);
            }
        )->reverse()->all();

        foreach ($data as $item) {
            $result[] = $this->collectItemData($item);
        }

        return collect($result);
    }

    protected function collectItemData($item)
    {
        $href = Arr::get($item, 'link')[count($item['link']) - 1]['@attributes']['href'];
        $slug = last(explode('/', $href));
        $slug = str_replace('.html', '', $slug);
        $thumb = (str_get_html($item['content']))->find('img', 0)->src;

        $data = [];
        $data['title'] = $item['title'];
        $data['content'] = $item['content'];
        $data['thumbnail'] = $thumb;
        $data['slug'] = $slug;

        $categories = collect($item['category'])
            ->filter(
                function ($item) {
                    return ($item['@attributes']['scheme'] ?? '') == 'http://www.blogger.com/atom/ns#';
                }
            )
            ->map(
                function ($item) {
                    return $item['@attributes']['term'];
                }
            )
            ->values()
            ->toArray();

        $data['categories'] = $categories;

        return $data;
    }
}

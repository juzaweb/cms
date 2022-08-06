<?php

namespace Juzaweb\CMS\Support\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BloggerXMLCollection implements XMLCollectionInterface
{
    public function getCollection($filePath): Collection
    {
        $data = $this->readXMLFile($filePath);
        $result = [];

        $data = collect(Arr::get($data, 'entry', []))->filter(
            function ($item) {
                return (strpos($item['id'], 'post-')
                    && $item['author']['name'] != 'Unknown'
                    && !str_contains($item['category']['@attributes']['term'] ?? '', 'kind#comment'));
            }
        )->reverse()->all();

        foreach ($data as $item) {
            $result[] = $this->collectItemData($item);
        }

        return collect($result);
    }

    protected function readXMLFile($filePath): array
    {
        $xmlObject = simplexml_load_file($filePath);
        return json_decode(json_encode($xmlObject), true);
    }

    protected function collectItemData($item): array
    {
        $href = Arr::get($item, 'link')[count($item['link']) - 1]['@attributes']['href'];
        $slug = last(explode('/', $href));
        $slug = str_replace('.html', '', $slug);
        $thumb = (str_get_html($item['content']))->find('img', 0)->src;

        $data = [];
        $data['title'] = $item['title'];
        $data['content'] = $item['content'];
        $data['thumbnail'] = $thumb;
        $data['type'] = 'posts';
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

<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Collections;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WordpressXMLCollection implements XMLCollectionInterface
{
    public function getCollection($filePath): Collection
    {
        $data = $this->readXMLFile($filePath);
        $result = [];
        foreach ($data->channel->item as $item) {
            $result[] = $this->collectItemData($item);
        }
        dd($result);
        return collect($result);
    }

    protected function collectItemData(\SimpleXMLElement $item): array
    {
        foreach ($item->category as $category) {
            $data[$this->parstTaxonomy((string) $category['domain'])][] = [
                'name' => (string) $category,
                'slug' => (string) $category['nicename'],
            ];
        }

        $data['title'] = (string) $item->title;
        $data['type'] = (string) $item->post_type;
        $data['slug'] = (string) $item->guid;
        $data['content'] = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;

        return $data;
    }

    protected function parstTaxonomy(string $taxonomy): string
    {
        if ($taxonomy == 'post_tag') {
            $taxonomy = 'tag';
        }

        return Str::plural($taxonomy);
    }

    protected function readXMLFile($filePath): \SimpleXMLElement|bool
    {
        return simplexml_load_file($filePath);
    }
}

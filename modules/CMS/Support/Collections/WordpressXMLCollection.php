<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
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

        return collect($result);
    }

    protected function collectItemData(\SimpleXMLElement $item): array
    {
        foreach ($item->category as $category) {
            $data[$this->parseTaxonomy((string) $category['domain'])][] = [
                'name' => (string) $category,
                'slug' => (string) $category['nicename'],
            ];
        }

        $data['title'] = (string) $item->title;
        $data['type'] = Str::plural((string) $this->getExportData($item, 'post_type'));
        $data['slug'] = (string) $this->getExportData($item, 'post_name');
        $data['content'] = $this->getContent($item);
        $data['metas'] = $this->getMetas($item);
        return $data;
    }

    protected function getMetas(\SimpleXMLElement $item): array
    {
        $metas = [];
        $data = $this->getExportData($item, 'postmeta');
        foreach ($data as $item) {
            $metas[(string) $item->meta_key] = (string) $item->meta_value;
        }
        return $metas;
    }

    protected function getExportData(\SimpleXMLElement $item, string $name): ?\SimpleXMLElement
    {
        return $item->children('http://wordpress.org/export/1.2/')->{$name};
    }

    protected function getContent(\SimpleXMLElement $item): string
    {
        $content = (string) $item->children('http://purl.org/rss/1.0/modules/content/')->encoded;

        return $content;
    }

    protected function parseTaxonomy(string $taxonomy): string
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

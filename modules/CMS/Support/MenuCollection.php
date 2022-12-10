<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MenuCollection
{
    protected Collection $item;

    /**
     * Make menu Collection
     *
     * @param array $items
     * @param string $sortBy
     * @return Collection
     */
    public static function make(array $items, string $sortBy = 'position'): Collection
    {
        $results = [];
        $items = collect($items)->sortBy($sortBy);
        foreach ($items as $item) {
            if ($children = Arr::get($item, 'children')) {
                $item['permissions'] = array_merge(
                    collect($children)->pluck('permissions')->unique()->toArray(),
                    $item['permissions'] ?? []
                );
            }

            $item = new static($item);
            $results[] = $item;
        }

        return new Collection($results);
    }

    public function __construct($item)
    {
        $this->item = collect($item);
    }

    public function hasChildren(): bool
    {
        if ($this->item->has('children')) {
            return count($this->item->get('children')) > 0;
        }

        return false;
    }

    public function get($key, $default = null)
    {
        return $this->item->get($key, $default);
    }

    public function getUrl(): string
    {
        $url = $this->get('url');
        if ($url == 'dashboard') {
            return '';
        }

        return '/' . $url;
    }

    public function getChildrens(): array|Collection
    {
        return static::make($this->item->get('children'));
    }
}

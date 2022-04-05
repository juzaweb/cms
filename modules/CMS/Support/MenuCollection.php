<?php

namespace Juzaweb\Support;

class MenuCollection
{
    protected $item;

    /**
     * Make menu Collection
     *
     * @param array $items
     * @param string $sortBy
     * @return MenuCollection[]
     */
    public static function make($items, $sortBy = 'position')
    {
        $results = [];
        $items = collect($items)->sortBy($sortBy);
        foreach ($items as $item) {
            $results[] = new static($item);
        }

        return $results;
    }

    public function __construct($item)
    {
        $this->item = collect($item);
    }

    public function hasChildren()
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

    public function getUrl()
    {
        $url = $this->get('url');
        if ($url == 'dashboard') {
            return '';
        }

        return '/' . $url;
    }

    public function getChildrens()
    {
        return static::make($this->item->get('children'));
    }
}

<?php

namespace Juzaweb\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection as BaseCollection;
use Juzaweb\Abstracts\Plugin;

class Collection extends BaseCollection
{
    /**
     * Get items collections.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            if ($value instanceof Plugin) {
                $attributes = $value->json()->getAttributes();
                $attributes["path"] = $value->getPath();

                return $attributes;
            }

            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->items);
    }
}

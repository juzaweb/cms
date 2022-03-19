<?php

namespace Juzaweb\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ArrayPagination
{
    /**
     * @var Collection
     */
    protected $items;

    public static function make($items)
    {
        return new static($items);
    }

    public function __construct($items)
    {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param int $perPage
     * @param int|null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator($this->items->forPage($page, $perPage), $this->items->count(), $perPage, $page, $options);
    }
}

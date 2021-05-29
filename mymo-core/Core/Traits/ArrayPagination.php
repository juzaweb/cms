<?php

namespace Mymo\Core\Traits;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ArrayPagination
{
    /**
     * The attributes that are mass assignable.
     *
     * @param array $items
     * @param int $perPage
     * @param int|null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function arrayPaginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
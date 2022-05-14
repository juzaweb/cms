<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ArrayPagination
{
    /**
     * @var Collection
     */
    protected Collection $items;

    public static function make(Collection|array $items): static
    {
        return new static($items);
    }

    public function __construct(Collection|array $items)
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
    public function paginate(int $perPage = 5, ?int $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        return new LengthAwarePaginator(
            $this->items->forPage($page, $perPage),
            $this->items->count(),
            $perPage,
            $page,
            $options
        );
    }

    public function where(string $key, $operator = null, $value = null): void
    {
        $this->items = $this->items->where($key, $operator, $value);
    }
}

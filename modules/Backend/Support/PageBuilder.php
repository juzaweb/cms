<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Support;

use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Juzaweb\Backend\Support\HTML\Row;

class PageBuilder
{
    protected array $items;

    public function addRow($callback, array $options = []): static
    {
        $row = new Row();

        $callback($row);

        $this->items[] = $row->toArray();

        return $this;
    }

    public function render(array $params = []): JsonResponse|Response
    {
        $params['fields'] = $this->toArray();

        return Inertia::render(
            'PageBuilder',
            $params
        );
    }

    public function toArray(): array
    {
        return $this->items;
    }
}

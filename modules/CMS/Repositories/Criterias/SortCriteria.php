<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Repositories\Abstracts\Criteria;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

class SortCriteria extends Criteria implements CriteriaInterface
{
    public function __construct(protected ?array $queries = null)
    {
        if (is_null($this->queries)) {
            $this->queries = request()->all();
        }
    }

    /**
     * Apply criteria in query repository
     *
     * @param  Builder|Model  $model
     * @param  RepositoryInterface  $repository
     *
     * @return Builder|Model
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository): Builder|Model
    {
        if (!method_exists($repository, 'getFieldSortable')) {
            return $model;
        }

        $fields = $repository->getFieldSortable();
        $tbl = $model->getModel()->getTable();
        $sortBy = Arr::get($this->queries, 'sort_by');

        if ($sortBy) {
            return $this->sortByQueryString($model, $repository, $sortBy, $fields, $tbl);
        }

        $hasSort = false;
        foreach ($this->queries as $col => $value) {
            if (!in_array($col, $fields, true)) {
                continue;
            }

            if (!in_array(strtoupper($value), ['ASC', 'DESC'])) {
                $value = 'ASC';
            }

            $model = $model->orderBy("{$tbl}.{$col}", $value);
            $hasSort = true;
        }

        if ($hasSort) {
            return $model;
        }

        return $this->sortByDefault($model, $repository, $tbl);
    }

    protected function sortByQueryString($model, RepositoryInterface $repository, $sortBy, $fields, $tbl): Builder|Model
    {
        $sortOrder = Arr::get($this->queries, 'sort_order', 'ASC');

        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }

        if ($sortBy && in_array($sortBy, $fields)) {
            return $model->orderBy("{$tbl}.{$sortBy}", $sortOrder);
        }

        return $this->sortByDefault($model, $repository, $tbl);
    }

    protected function sortByDefault($model, $repository, $tbl)
    {
        if (!method_exists($repository, 'getSortableDefaults')) {
            return $model;
        }

        $defaults = $repository->getSortableDefaults();
        foreach ($defaults as $col => $order) {
            $model = $model->orderBy("{$tbl}.{$col}", $order);
        }

        return $model;
    }
}

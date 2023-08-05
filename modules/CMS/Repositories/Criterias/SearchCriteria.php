<?php

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Interfaces\Repositories\WithAppendSearch;
use Juzaweb\CMS\Repositories\Abstracts\Criteria;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

class SearchCriteria extends Criteria implements CriteriaInterface
{
    public function __construct(protected ?array $queries = null)
    {
        if (is_null($this->queries)) {
            $this->queries = request()?->all();
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
        if (!method_exists($repository, 'getFieldSearchable')) {
            // To query builder
            return $model->whereRaw('1=1');
        }

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $fields = $repository->getFieldSearchable();
        $keyword = Arr::get($this->queries, 'q', Arr::get($this->queries, 'keyword'));
        $condition = $driver == 'pgsql' ? 'ilike' : 'like';

        if (empty($keyword)) {
            // To query builder
            return $model->whereRaw('1=1');
        }

        $tbl = $model->getModel()->getTable();
        return $model->where(
            function ($query) use ($fields, $keyword, $tbl, $repository, $condition) {
                $isFirstField = true;
                $value = "%{$keyword}%";

                foreach ($fields as $field) {
                    if ($isFirstField) {
                        $query->where("{$tbl}.{$field}", $condition, $value);
                        $isFirstField = false;
                    } else {
                        $query->orWhere("{$tbl}.{$field}", $condition, $value);
                    }
                }

                if ($repository instanceof WithAppendSearch) {
                    if ($isFirstField) {
                        $query->where(
                            function ($q) use ($repository, $keyword) {
                                return $repository->appendCustomSearch($q, $keyword, $this->queries);
                            }
                        );
                    } else {
                        $query->orWhere(
                            function ($q) use ($repository, $keyword) {
                                return $repository->appendCustomSearch($q, $keyword, $this->queries);
                            }
                        );
                    }
                }
            }
        );
    }
}

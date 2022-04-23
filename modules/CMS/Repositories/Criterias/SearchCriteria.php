<?php

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class SearchCriteria implements CriteriaInterface
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Builder|Model     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $fields = $repository->getFieldSearchable();
        $value = $this->request->input('q');
        $condition = $driver == 'pgsql' ? 'ilike' : 'like';

        if (empty($value)) {
            return $model;
        }

        return $model->where(
            function ($query) use ($fields, $condition, $value) {
                $isFirstField = true;
                $value = "%{$value}%";

                foreach ($fields as $field) {
                    if ($isFirstField) {
                        $query->where($field, $condition, $value);
                        $isFirstField = false;
                    } else {
                        $query->orWhere($field, $condition, $value);
                    }
                }
            }
        );
    }
}

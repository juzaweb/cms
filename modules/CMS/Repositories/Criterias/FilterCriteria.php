<?php

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
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
        $fields = $repository->getFieldFilterable();

        return $model->where(
            function ($query) use ($fields) {
                $isFirstField = true;

                foreach ($fields as $field => $condition) {
                    if (is_numeric($field)) {
                        $field = $condition;
                        $condition = "=";
                    }

                    if (!$this->request->has($field)) {
                        continue;
                    }

                    $condition = trim(strtolower($condition));
                    $value = $this->getValueRequest($field, $condition);

                    if (is_null($value)) {
                        continue;
                    }

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

    protected function getValueRequest(string $field, string $condition): mixed
    {
        $search = $this->request->input($field);
        $value = null;

        if (!is_null($search) && !in_array($condition, ['in', 'between'])) {
            $value = ($condition == "like" || $condition == "ilike") ? "%{$search}%" : $search;
        }

        if ($condition == 'in') {
            $value = explode(',', $value);
            if (trim($value[0]) === "" || $field == $value[0]) {
                $value = null;
            }
        }

        if ($condition == 'between') {
            $value = explode(',', $value);
            if (count($value) < 2) {
                $value = null;
            }
        }

        return $value;
    }
}

<?php

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

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
     * @param  Builder|Model  $model
     * @param  RepositoryInterface  $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fields = $repository->getFieldFilterable();
        
        $input = $this->request->query();
        
        return $model->where(
            function ($query) use ($fields, $input, $repository) {
                foreach ($fields as $field => $condition) {
                    if (is_numeric($field)) {
                        $field = $condition;
                        $condition = "=";
                    }
                    
                    if (!$this->request->has($field)) {
                        continue;
                    }
                    
                    if (is_array($condition)) {
                        $column = key($condition);
                        $condition = $condition[$column];
                        $value = $this->getValueRequest($field, $condition);
                    } else {
                        $condition = trim(strtolower($condition));
                        $value = $this->getValueRequest($field, $condition);
                        $column = $field;
                    }
                    
                    switch ($condition) {
                        case 'in':
                            $query->whereIn($column, $value);
                            break;
                        case 'between':
                            $query->whereBetween($column, $value[0], $value[1]);
                            break;
                        default:
                            $query->where($column, $condition, $value);
                    }
                }
                
                if ($repository instanceof WithAppendFilter) {
                    $query = $repository->appendCustomFilter($query, $input);
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

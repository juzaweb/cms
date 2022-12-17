<?php

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

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
     * @param  Builder|Model  $model
     * @param  RepositoryInterface  $repository
     *
     * @return mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository): mixed
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        
        $fields = $repository->getFieldSearchable();
        $keyword = $this->request->input('q');
        $input = $this->request->input();
        $condition = $driver == 'pgsql' ? 'ilike' : 'like';
        
        if (empty($value)) {
            return $model;
        }
        
        $tbl = $model->getModel()->getTable();
        return $model->where(
            function ($query) use ($fields, $keyword, $tbl, $input, $repository, $condition) {
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
                            function ($q) use ($repository, $keyword, $input) {
                                return $repository->appendCustomSearch($q, $keyword, $input);
                            }
                        );
                    } else {
                        $query->orWhere(
                            function ($q) use ($repository, $keyword, $input) {
                                return $repository->appendCustomSearch($q, $keyword, $input);
                            }
                        );
                    }
                }
            }
        );
    }
}

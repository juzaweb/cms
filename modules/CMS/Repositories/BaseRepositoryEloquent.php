<?php

namespace Juzaweb\CMS\Repositories;

use Juzaweb\CMS\Repositories\Eloquent\BaseRepository as PackageBaseRepository;

abstract class BaseRepositoryEloquent extends PackageBaseRepository
{
    protected array $filterableFields = [];
    
    protected array $searchableFields = [];
    
    public function updateOrCreate(array $attributes, array $values = []): mixed
    {
        $model = $this->model->where($attributes)->first();
        
        if ($model) {
            $model = $this->update(
                array_merge($attributes, $values),
                $model->id
            );
        } else {
            $model = $this->create(array_merge($attributes, $values));
        }
        
        return $this->parserResult($model);
    }
}

<?php

namespace Juzaweb\CMS\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\CMS\Repositories\Eloquent\BaseRepository as PackageBaseRepository;

abstract class BaseRepositoryEloquent extends PackageBaseRepository
{
    protected array $filterableFields = [];
    protected array $searchableFields = [];
    protected array $sortableFields = [];
    protected array $sortableDefaults = [];

    public function getQuery(): Builder
    {
        $this->applyCriteria();
        $this->applyScope();

        $query = $this->model->newQuery();

        $this->resetCriteria();
        $this->resetScope();
        $this->resetModel();

        return $query;
    }

    public function resetModel(): void
    {
        $this->resetCriteria();
        $this->resetScope();
        parent::resetModel();
    }

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

<?php

namespace Juzaweb\CMS\Repositories;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository as PackageBaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class BaseRepositoryEloquent extends PackageBaseRepository
{
    protected array $filterAble = [];

    protected array $searchAble = [];

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return \Prettus\Repository\Eloquent\BaseRepository
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function pushCriteria($criteria): PackageBaseRepository
    {
        if (is_string($criteria)) {
            $criteria = app($criteria);
        }

        if (!$criteria instanceof CriteriaInterface) {
            throw new RepositoryException(
                "Class " . get_class($criteria)
                . " must be an instance of Prettus\\Repository\\Contracts\\CriteriaInterface"
            );
        }

        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * Push Criteria for filter the query
     *
     * @param array|string $criteria
     *
     * @return \Prettus\Repository\Eloquent\BaseRepository
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function pushCriterias(array|string $criterias): PackageBaseRepository
    {
        if (is_string($criterias)) {
            $criterias = [$criterias];
        }

        foreach ($criterias as $criteria) {
            $this->pushCriteria($criteria);
        }

        return $this;
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

<?php

namespace Juzaweb\CMS\Repositories\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Repositories\Contracts\CriteriaInterface;
use Juzaweb\CMS\Repositories\Contracts\RepositoryInterface;

class CacheCriteria implements CriteriaInterface
{
    protected null|int|\DateTime $ttl;

    public function __construct(null|int|\DateTime $ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * Apply criteria in query repository
     *
     * @param  Builder|Model  $model
     * @param  RepositoryInterface  $repository
     *
     * @return Builder
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->cacheFor($this->ttl);
    }
}

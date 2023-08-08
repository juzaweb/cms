<?php

namespace Juzaweb\CMS\Repositories\Contracts;

use Illuminate\Support\Collection;
use Juzaweb\CMS\Repositories\Eloquent\BaseRepository as PackageBaseRepository;

/**
 * Interface RepositoryCriteriaInterface
 *
 * @package Prettus\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface RepositoryCriteriaInterface
{
    public function pushCriteria(string|CriteriaInterface $criteria): PackageBaseRepository;

    /**
     * Push Criteria for filter the query
     *
     * @param $criteria
     *
     * @return $this
     */
    public function pushCriterias(array|string $criterias): PackageBaseRepository;

    /**
     * Pop Criteria
     *
     * @param $criteria
     *
     * @return $this
     */
    public function popCriteria($criteria);

    /**
     * Get Collection of Criteria
     *
     * @return Collection
     */
    public function getCriteria();

    /**
     * Find data by Criteria
     *
     * @param  CriteriaInterface  $criteria
     *
     * @return mixed
     */
    public function getByCriteria(CriteriaInterface $criteria);

    /**
     * Skip Criteria
     *
     * @param  bool  $status
     *
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * Reset all Criterias
     *
     * @return $this
     */
    public function resetCriteria();
}

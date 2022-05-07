<?php

namespace Juzaweb\CMS\Traits\Criterias;

/**
 * @property array $searchAble
 */
trait UseSearchCriteria
{
    public function getFieldSearchable(): array
    {
        return $this->searchAble;
    }
}

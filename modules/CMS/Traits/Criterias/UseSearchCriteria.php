<?php

namespace Juzaweb\CMS\Traits\Criterias;

/**
 * @property array $searchable
 */
trait UseSearchCriteria
{
    public function getFieldSearchable(): array
    {
        return $this->searchable;
    }
}

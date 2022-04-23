<?php

namespace Juzaweb\CMS\Traits\Criterias;

/**
 * @property array $filterable
 */
trait UseFilterCriteria
{
    public function getFieldFilterable(): array
    {
        return $this->filterable;
    }
}

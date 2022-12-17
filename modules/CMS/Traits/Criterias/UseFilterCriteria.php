<?php

namespace Juzaweb\CMS\Traits\Criterias;

/**
 * @property array $filterableFields
 */
trait UseFilterCriteria
{
    public function getFieldFilterable(): array
    {
        return $this->filterableFields ?? [];
    }
}

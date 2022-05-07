<?php

namespace Juzaweb\CMS\Traits\Criterias;

/**
 * @property array $filterAble
 */
trait UseFilterCriteria
{
    public function getFieldFilterable(): array
    {
        return $this->filterAble;
    }
}

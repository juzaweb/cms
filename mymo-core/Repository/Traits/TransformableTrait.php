<?php

namespace Tadcms\Repository\Traits;

/**
 * Class TransformableTrait
 * @package Tadcms\Repository\Traits
 * @author Anderson Andrade <contato@andersonandra.de>
 */
trait TransformableTrait
{
    /**
     * @return array
     */
    public function transform()
    {
        return $this->toArray();
    }
}

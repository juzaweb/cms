<?php

namespace Mymo\Repository\Traits;

/**
 * Class TransformableTrait
 * @package Mymo\Repository\Traits
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

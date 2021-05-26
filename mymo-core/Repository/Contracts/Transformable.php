<?php

namespace Tadcms\Repository\Contracts;

/**
 * Interface Transformable
 * @package Tadcms\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface Transformable
{
    /**
     * @return array
     */
    public function transform();
}

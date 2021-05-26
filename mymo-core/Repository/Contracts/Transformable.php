<?php

namespace Mymo\Repository\Contracts;

/**
 * Interface Transformable
 * @package Mymo\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface Transformable
{
    /**
     * @return array
     */
    public function transform();
}

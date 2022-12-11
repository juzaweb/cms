<?php

namespace Juzaweb\CMS\Repositories\Contracts;

/**
 * Interface PresenterInterface
 *
 * @package Prettus\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface PresenterInterface
{
    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     */
    public function present($data);
}

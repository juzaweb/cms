<?php

namespace Juzaweb\CMS\Repositories\Contracts;

/**
 * Interface Presentable
 *
 * @package Prettus\Repository\Contracts
 * @author Anderson Andrade <contato@andersonandra.de>
 */
interface Presentable
{
    /**
     * @param  PresenterInterface  $presenter
     *
     * @return mixed
     */
    public function setPresenter(PresenterInterface $presenter);

    /**
     * @return mixed
     */
    public function presenter();
}

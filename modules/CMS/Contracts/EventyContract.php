<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

interface EventyContract
{
    public function getAction();

    public function getFilter();

    public function addAction($hook, $callback, $priority = 20, $arguments = 1);

    public function removeAction($hook, $callback, $priority = 20);

    public function removeAllActions($hook = null);

    public function addFilter($hook, $callback, $priority = 20, $arguments = 1);

    public function removeFilter($hook, $callback, $priority = 20);

    public function removeAllFilters($hook = null);

    public function allAction();
}

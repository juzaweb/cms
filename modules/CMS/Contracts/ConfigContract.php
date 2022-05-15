<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Contracts;

use Juzaweb\CMS\Models\Config;

interface ConfigContract
{
    public function getConfig($key, $default = null): mixed;

    public function setConfig($key, $value = null): Config;
}

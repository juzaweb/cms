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

use Illuminate\Support\Collection;
use Juzaweb\CMS\Models\Config;
use Juzaweb\CMS\Models\Config as ConfigModel;

interface ConfigContract
{
    public function getConfig(string $key, string|array $default = null): null|string|array;
    
    public function setConfig(string $key, string|array $value = null): ConfigModel;
    
    public function getConfigs(array $keys, string|array $default = null): array;
    
    public function all(): Collection;
}

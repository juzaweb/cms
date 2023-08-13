<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Interfaces\Theme;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Juzaweb\CMS\Support\Plugin;

/**
 * @see Plugin
 */
interface PluginInterface extends Arrayable
{
    public function getPath(string $path = ''): string;

    public function getInfo(bool $assoc = false): array|Collection;
}

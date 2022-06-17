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

interface HookActionContract
{
    public function getMenuBoxs(array $keys = []): array;

    public function getProfilePages($key = null): Collection;
}

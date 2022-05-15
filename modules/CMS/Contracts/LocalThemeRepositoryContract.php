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
use Juzaweb\CMS\Support\Theme;

interface LocalThemeRepositoryContract
{
    public function scan(bool $collection = false): array|Collection;

    public function find(string $name): ?Theme;

    public function all(bool $collection = false): array|Collection;
}

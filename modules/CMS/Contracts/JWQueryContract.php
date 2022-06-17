<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Contracts;

use Illuminate\Support\Collection;

interface JWQueryContract
{
    public function queryRows(string $table, array $args = []): Collection|null;

    public function queryRow(string $table, array $args = []): object|null;
}

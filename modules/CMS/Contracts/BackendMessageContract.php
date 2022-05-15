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

interface BackendMessageContract
{
    public function all(): array;

    public function add(string $group, array|string $message, string $status): void;

    public function delete(string $id): bool;

    public function deleteGroup(string $group): bool;
}

<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Contracts;

interface JuzawebApiContract
{
    public function login(string $email, string $password): bool;

    public function checkActivationCode(string $module, string $name, string $code): object;

    public function getActivationCodes(string $module, string $name): object;

    public function setAccessToken(string $accessToken): void;

    public function getAccessToken(): ?string;

    public function get(string $uri, array $params = [], array $headers = []): object|array;
}

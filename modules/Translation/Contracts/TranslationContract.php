<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Translation\Contracts;

use Illuminate\Support\Collection;

interface TranslationContract
{
    public function all(): Collection;

    public function getLocalePlugins(): array;

    public function getLocaleThemes(): array;

    public function getByKey(string $key): mixed;

    public function getAllTrans(Collection|string $key, string $locale): array;

    public function allLanguageOrigin(Collection|string $key): array;

    public function allLanguagePublish(Collection|string $key): array;

    public function allLanguage(Collection|string $key): array;

    public function originPath(Collection|string $key, string $path = ''): string;

    public function publishPath(Collection|string $key, $path = ''): string;
}

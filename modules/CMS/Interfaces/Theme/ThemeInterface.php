<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Interfaces\Theme;

use Illuminate\Support\Collection;
use Juzaweb\CMS\Support\Theme;

/**
 * @see Theme
 */
interface ThemeInterface
{
    public function getLangPublicPath(string $path = null): string;

    public function getVersion(): string;

    public function getScreenshot(): string;

    public function getInfo(bool $assoc = false): null|array|Collection;

    public function getConfigFields(): array;

    public function isActive(): bool;

    public function activate(): void;

    public function getTemplate(): string;

    public function getRegister($key = null, $default = null): string|array|null;
}

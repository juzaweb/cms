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

/**
 * @see \Juzaweb\CMS\Support\GoogleTranslate
 */
interface GoogleTranslate
{
    public function translate(string $source, string $target, string $text): string;

    public function withProxy(string|array $proxy): static;
}

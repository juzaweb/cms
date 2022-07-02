<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Contracts;

interface NetworkRegistionContract
{
    public function init(): void;

    public function getCurrentSite(): object;

    public function isRootSite($domain = null): bool;

    public function getCurrentDomain(): string;
}

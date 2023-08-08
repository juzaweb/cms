<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Contracts;

/**
 * @see \Juzaweb\Network\Support\SiteSetup
 */
interface SiteSetupContract
{
    public function setup(object $site): object;

    public function setupConfig(object $site): void;

    public function setupDatabase(object $site): object;
}

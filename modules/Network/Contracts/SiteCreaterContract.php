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

use Juzaweb\Network\Models\Site;

interface SiteCreaterContract
{
    public function create(string $subdomain, array $args = []): Site;

    public function setupSite(Site $site);
}

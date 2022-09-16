<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Support;

use Juzaweb\Network\Contracts\NetworkSiteContract;
use Juzaweb\Network\Models\Site;

class NetworkSite implements NetworkSiteContract
{
    protected Site $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }
}

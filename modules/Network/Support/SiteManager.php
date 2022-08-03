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

use Juzaweb\Network\Contracts\SiteManagerContract;
use Juzaweb\Network\Models\Site;

class SiteManager implements SiteManagerContract
{
    public function __construct($db)
    {
        //
    }

    public function find(string|int|Site $site)
    {
        if (is_numeric($site)) {
            $site = Site::find($site);
        }

        if (is_string($site)) {
            $site = Site::where(['domain' => $site])->first();
        }

        if (empty($site)) {
            return null;
        }

        return $this->createSite($site);
    }

    private function createSite(Site $site)
    {
        //
    }
}

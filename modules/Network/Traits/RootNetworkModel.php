<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Traits;

use Juzaweb\Network\Facades\Network;

trait RootNetworkModel
{
    public function getConnectionName()
    {
        if (config('network.enable') && !Network::isRootSite()) {
            return Network::getCurrentSite()->root_connection;
        }

        return $this->connection;
    }
}

<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\CMS\Console\Commands;

use Illuminate\Console\Command;
use Juzaweb\CMS\Version;

class VersionCommand extends Command
{
    protected $name = 'juza:version';

    public function handle()
    {
        echo Version::getVersion();
    }
}

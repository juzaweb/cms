<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Traits;

use Illuminate\Support\Facades\DB;
use Juzaweb\Multisite\Models\Site;
use Illuminate\Support\Facades\Config;

trait MultisiteCli
{
    public function setUpSite($siteId)
    {
        if (empty($siteId)) {
            $site = new \stdClass();
            $site->id = null;
            $GLOBALS['site'] = $site;
            return;
        }

        $db = DB::connection('pgsql');
        $site = $db->table('sites')
            ->where('id', '=', $siteId)
            ->first();

        if (empty($site)) {
            throw new \Exception('Site not found.');
        }

        if ($site->status == Site::STATUS_BANNED) {
            throw new \Exception('Site has been banned.');
        }

        $db = $db->table('databases')
            ->where('id', '=', $site->db_id)
            ->first();

        if (empty($db)) {
            throw new \Exception('Site not found.');
        }

        $GLOBALS['site'] = $site;

        Config::set(
            'database.connections.subsite',
            array_merge(
                Config::get('database.connections.subsite'),
                [
                    'host' => $db->dbhost,
                    'port' => $db->dbport,
                    'database' => $db->dbname,
                    'username' => $db->dbuser,
                    'password' => (string) $db->dbpass,
                    'prefix' => (string) $db->dbprefix,
                ]
            )
        );

        Config::set('database.default', 'subsite');

        DB::purge('subsite');

        $mail = \Juzaweb\Models\Config::getConfig('email', []);

        if ($mail) {
            $config = [
                'driver' => $mail['driver'] ?? 'smtp',
                'host' => $mail['host'] ?? '',
                'port' => $mail['port'] ?? '',
                'from' => [
                    'address' => $mail['from_address'] ?? '',
                    'name' => $mail['from_name'] ?? '',
                ],
                'encryption' => $mail['encryption'] ?? '',
                'username' => $mail['username'] ?? '',
                'password' => $mail['password'] ?? '',
            ];

            Config::set('mail', $config);
        }
    }
}

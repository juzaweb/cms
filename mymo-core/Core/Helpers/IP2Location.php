<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 10:05 PM
 */

namespace Mymo\Core\Helpers;

use IP2Location\Database;

class IP2Location
{
    /**
     * @var Database $db
     * */
    protected $db;

    private function load()
    {
        $this->db = new Database($this->getDatabasePath(), Database::FILE_IO);
    }

    private function getDatabasePath()
    {
        return core_path('database/iplocation/IPV6-COUNTRY.BIN');
    }

    public function get($ip, $mode = 'bin')
    {
        $this->load();
        $records = $this->db->lookup($ip, Database::ALL);
        return $records;
    }
}

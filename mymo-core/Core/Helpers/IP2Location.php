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

class IP2Location
{
    private function load()
    {
        $this->db = new \IP2Location\Database($this->getDatabasePath(), \IP2Location\Database::FILE_IO);
    }

    private function getDatabasePath()
    {
        return core_path('database/iplocation/IPV6-COUNTRY.BIN');
    }

    public function get($ip, $mode = 'bin')
    {
        $this->load();
        $records = $this->db->lookup($ip, \IP2Location\Database::ALL);
        return $records;
    }
}

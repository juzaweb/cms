<?php

namespace Mymo\Core\Helpers;

class IP2Location
{
    private function load($mode)
    {
        if ($mode == 'bin')
        {
            $this->db = new \IP2Location\Database($this->getDatabasePath(), \IP2Location\Database::FILE_IO);
        } else if ($mode == 'ws')
        {
            $apikey = \Config::get('site_vars.IP2LocationAPIKey');
            $package = (null !== \Config::get('site_vars.IP2LocationPackage')) ? \Config::get('site_vars.IP2LocationPackage') : 'WS1';
            $ssl = (null !== \Config::get('site_vars.IP2LocationUsessl')) ? \Config::get('site_vars.IP2LocationUsessl') : false;
            $this->ws = new \IP2Location\WebService($apikey, $package, $ssl);
        }
    }

    private function getDatabasePath()
    {
        return config('ip2locationlaravel.ip2location.local.path');
    }

    public function get($ip, $mode = 'bin')
    {
        $this->load($mode);
        if ($mode == 'bin')
        {
            $records = $this->db->lookup($ip, \IP2Location\Database::ALL);
        } else if ($mode == 'ws')
        {
            $addons = (null !== \Config::get('site_vars.IP2LocationAddons')) ? \Config::get('site_vars.IP2LocationAddons') : [];
            $language = (null !== \Config::get('site_vars.IP2LocationLanguage')) ? \Config::get('site_vars.IP2LocationLanguage') : 'en';
            $records = $this->ws->lookup($ip, $addons, $language);
        }
        
        return $records;
    }
}

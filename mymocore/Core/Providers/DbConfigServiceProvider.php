<?php

namespace Mymo\Core\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class DbConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->checkDbConnection()) {
            return;
        }
        
        $mail = get_config('email');
        if ($mail) {
            $config = [
                'driver'     => 'smtp',
                'host'       => $mail['host'],
                'port'       => (int) $mail['port'],
                'from'       => [
                    'address'   => $mail['from_address'],
                    'name'      => $mail['from_name']
                ],
                'encryption' => $mail['encryption'],
                'username'   => $mail['username'],
                'password'   => $mail['password'],
            ];

            Config::set('mail', $config);
        }
    }
    
    protected function checkDbConnection()
    {
        try {
            DB::connection()->getPdo();

            if (Schema::hasTable('configs')) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    
        return false;
    }
}

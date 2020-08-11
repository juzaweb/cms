<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function index() {
        $update = false;
        if ($this->_countMigrations() > $this->_countExecutedMigrations()) {
            $update = true;
        }
        
        return view('installer.update', [
            'update' => $update,
        ]);
    }
    
    public function update() {
        \Artisan::call('migrate');
    
        return response()->json([
            'status' => 'success',
            'message' => 'Update success',
            'redirect' => route('home'),
        ]);
    }
    
    private function _countMigrations()
    {
        $migrations = glob(database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'*.php');
        //$migrations = str_replace('.php', '', $migrations);
        return count($migrations);
    }
    
    private function _countExecutedMigrations()
    {
        return \DB::table('migrations')
            ->pluck('migration')
            ->count();
    }
}

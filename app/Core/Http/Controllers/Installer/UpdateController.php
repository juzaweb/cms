<?php

namespace App\Core\Http\Controllers\Installer;

use App\Core\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function index() {
        $update = false;
        if ($this->_countMigrations() > $this->_countExecutedMigrations()) {
            $update = true;
        }
        
        return view('installer.update.index', [
            'update' => $update,
        ]);
    }
    
    public function update() {
        \Artisan::call('migrate', ['--force' => true]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Update success',
            'redirect' => route('home'),
        ]);
    }
    
    private function _countMigrations()
    {
        $mainPath = database_path('migrations');
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $total = 0;
        
        foreach ($paths as $path) {
            $migrations = glob($path . DIRECTORY_SEPARATOR . '*.php');
            $total += count($migrations);
        }
        
        return $total;
    }
    
    private function _countExecutedMigrations()
    {
        return \DB::table('migrations')
            ->pluck('migration')
            ->count();
    }
}

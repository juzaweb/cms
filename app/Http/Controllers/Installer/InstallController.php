<?php

namespace App\Http\Controllers\Installer;

use App\Helpers\PermissionsChecker;
use App\Helpers\RequirementsChecker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;

class InstallController extends Controller
{
    protected $requirements;
    protected $permissions;
    
    public function __construct(RequirementsChecker $requirements, PermissionsChecker $permissions) {
        $this->requirements = $requirements;
        $this->permissions = $permissions;
    }
    
    public function index() {
        if (file_exists(storage_path('installed'))) {
            return abort(404);
        }
        
        \Artisan::call('config:clear');
        if (!$this->_testDbConnect()) {
            return '<h1>Cannot connect database!!!</h1>';
        }
        
        $php_support = $this->_checkPHPversion('7.1.3');
        $requirements = $this->_checkRequirements();
        $permissions = $this->_checkPermissionFolder();
        
        return view('installer.install.index', [
            'php_support' => $php_support,
            'requirements' => $requirements,
            'permissions' => $permissions,
        ]);
    }
    
    public function install(Request $request) {
        $this->validateRequest([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:32|confirmed',
            'password_confirmation' => 'required|string|min:6|max:32',
        ], $request);
        
        try {
            
            if (!$this->_testDbConnect()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cannot connect database!!!',
                ]);
            }
            
            return response()->json([
                'status' => 'success',
            ]);
        }
        catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
    
    public function step($step, Request $request) {
        ini_set('max_execution_time', 300);
        $data = $request->all();
        
        $flash = '';
        switch ($step) {
            case 1: $this->_runMigration();
                $flash = 'Run database';
            break;
            case 2: $this->_createAdminUser($data);
                $flash = 'Created user Admin';
            break;
            case 3: $this->_createInstalled();
                $flash = 'Created install file';
            break;
        }
    
        if ($step < 3) {
            return response()->json([
                'status' => 'success',
                'flash' => $flash,
                'next_step' => $step + 1,
            ]);
        }
    
        return response()->json([
            'status' => 'success',
            'flash' => 'Install success',
            'redirect' => route('home'),
        ]);
    }
    
    private function _checkPHPversion($min_version) {
        return $this->requirements->checkPHPversion($min_version);
    }
    
    private function _checkRequirements() {
        return $this->requirements->check(
            [
                'php' => [
                    'openssl',
                    'pdo',
                    'mbstring',
                    'tokenizer',
                    'JSON',
                    'cURL',
                ],
                'apache' => [
                    'mod_rewrite',
                ],
            ]
        );
    }
    
    private function _checkPermissionFolder() {
        return $this->permissions->check(
            [
                'resources/views/emails'     => '775',
                'storage/'     => '777',
                'bootstrap/cache/'       => '777',
        ]);
    }
    
    private function _testDbConnect() {
        try {
            \DB::connection()->getPdo();
        
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    private function _writeEnvFile(array $data) {
        $env = file_get_contents(base_path() . '/.env.example');
        $env = str_replace('APP_ENV=local', 'APP_ENV=production', $env);
        $env = str_replace('APP_KEY=123456', 'APP_KEY=base64:'.base64_encode(Str::random(32)), $env);
        $env = str_replace('APP_URL=', 'APP_URL=' . url('/'), $env);
        $env = str_replace('DB_HOST=', 'DB_HOST=' . $data['dbhost'], $env);
        $env = str_replace('DB_PORT=', 'DB_PORT=' . $data['dbport'], $env);
        $env = str_replace('DB_DATABASE=', 'DB_DATABASE=' . $data['dbname'], $env);
        $env = str_replace('DB_USERNAME=', 'DB_USERNAME=' . $data['dbuser'], $env);
        $env = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $data['dbpass'], $env);
        $env = str_replace('DB_PREFIX=', 'DB_PREFIX=' . str_replace('-', '_', $data['dbprefix']), $env);
        
        if (file_exists(base_path() . '/.env')) {
            unlink(base_path() . '/.env');
        }
        
        return file_put_contents(base_path() . '/.env', $env);
    }
    
    private function _runMigration() {
        \Artisan::call('migrate', ['--force' => true]);
    }
    
    private function _createAdminUser(array $data) {
        $model = new User();
        $model->fill($data);
        $model->password = \Hash::make($data['password']);
        $model->is_admin = 1;
        return $model->save();
    }
    
    private function _createInstalled() {
        return file_put_contents(storage_path('installed'), 'Installed');
    }
}

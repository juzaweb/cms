<?php

namespace App\Http\Controllers\Installer;

use App\Helpers\PermissionsChecker;
use App\Helpers\RequirementsChecker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class InstallController extends Controller
{
    protected $requirements;
    protected $permissions;
    
    public function __construct(RequirementsChecker $requirements, PermissionsChecker $permissions) {
        $this->requirements = $requirements;
        $this->permissions = $permissions;
    }
    
    public function index() {
        if (file_exists(base_path('.env'))) {
            return abort(404);
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
            'dbhost' => 'required',
            'dbport' => 'required',
            'dbuser' => 'required',
            'dbpass' => 'nullable',
            'dbname' => 'required',
            'dbprefix' => 'nullable',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:32|confirmed',
            'password_confirmation' => 'required|string|min:6|max:32',
        ], $request);
    
        ini_set('max_execution_time', 300);
        
        try {
            $connection = $this->_testDbConnect($request->all());
            if ($connection !== true) {
                return response()->json([
                    'status' => 'error',
                    'message' => $connection,
                ]);
            }
    
            $this->_writeEnvFile($request->all());
            $this->_callArtisan();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Install success',
                'redirect' => route('home'),
            ]);
        }
        catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
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
            '/'     => '775',
            'resources/views/emails'     => '775',
            'storage/'     => '777',
            'bootstrap/cache/'       => '777',
        ]);
    }
    
    private function _testDbConnect(array $data) {
        try{
            $port = $data['dbport'] ? 'port='. $data['dbport'] .';' : '';
            $connection = new \PDO("mysql:host=". $data['dbhost'] .";". $port ."dbname=". $data['dbname'] .";charset=utf8", $data['dbuser'], $data['dbpass']);
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        }
        catch(\PDOException $e){
            return 'Cannot connect database!!!';
        }
    }
    
    private function _writeEnvFile(array $data) {
        $env = file_get_contents(base_path() . '/.env.example');
        $env = str_replace('APP_KEY=', 'APP_KEY=base64:'.base64_encode(Str::random(32)), $env);
        $env = str_replace('APP_URL=', 'APP_URL=' . $_SERVER['HTTP_HOST'], $env);
        $env = str_replace('DB_HOST=', 'DB_HOST=' . $data['dbhost'], $env);
        $env = str_replace('DB_PORT=', 'DB_PORT=' . $data['dbport'], $env);
        $env = str_replace('DB_DATABASE=', 'DB_DATABASE=' . $data['dbname'], $env);
        $env = str_replace('DB_USERNAME=', 'DB_USERNAME=' . $data['dbuser'], $env);
        $env = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $data['dbpass'], $env);
        $env = str_replace('DB_PREFIX=', 'DB_PREFIX=' . $data['dbprefix'], $env);
        
        return file_put_contents(base_path() . '/.env', $env);
    }
    
    private function _callArtisan() {
        \Artisan::call('config:clear');
        \Artisan::call('migrate');
    }
}

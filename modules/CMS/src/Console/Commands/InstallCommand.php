<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Models\User;
use Juzaweb\Support\Manager\DatabaseManager;
use Juzaweb\Support\Manager\FinalInstallManager;
use Juzaweb\Support\Manager\InstalledFileManager;

class InstallCommand extends Command
{
    protected $signature = 'juzacms:install';

    protected $user;

    public function handle(
        DatabaseManager $databaseManager,
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall
    ) {
        $this->info('JUZACMS INSTALLER');
        $this->info('-- Database Install');
        
        $result = $databaseManager->run();
        if (Arr::get($result, 'status') == 'error') {
            throw new \Exception($result['message']);
        }

        $this->info('-- Publish assets');
        $result = $finalInstall->runFinal();
        if (Arr::get($result, 'status') == 'error') {
            throw new \Exception($result['message']);
        }

        $this->info('-- Create user admin');
        $this->call('juzacms:make-admin');
        
        $this->info('-- Update installed');
        $fileManager->update();
        
        $this->info('CMS Install Successfully !!!');
        
        return self::SUCCESS;
    }

    protected function createAdminUser()
    {
        $this->user['name'] = $this->ask('Full Name?');
        $this->user['email'] = $this->ask('Email?');
        $this->user['password'] = $this->ask('Password?');

        $validator = Validator::make($this->user, [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|max:32|min:6',
        ], [], [
            'name' => trans('cms::app.name'),
            'email' => trans('cms::app.email'),
            'password' => trans('cms::app.password'),
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->messages()[0]);
            $this->createAdminUser();
        }

        DB::beginTransaction();
        try {
            $model = new User();
            $model->fill($this->user);
            $model->password = Hash::make($this->user['password']);
            $model->is_admin = 1;
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

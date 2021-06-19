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
 * Date: 6/19/2021
 * Time: 11:22 AM
 */

namespace Mymo\Installer\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mymo\Installer\Helpers\DatabaseManager;
use Mymo\Installer\Helpers\FinalInstallManager;
use Mymo\Installer\Helpers\InstalledFileManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Mymo\Core\Models\User;

class InstallCommand extends Command
{
    protected $signature = 'mymo:install';

    protected $user;

    public function handle(
        DatabaseManager $databaseManager,
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall
    )
    {
        $this->info('MYMO CMS Installer');
        $this->info('-- Database Install');
        $databaseManager->run();
        $this->info('-- Publish assets');
        $finalInstall->runFinal();
        $this->info('-- Create user admin');
        $this->createAdminUser();
        $this->info('-- Update installed');
        $fileManager->update();
        $this->info('MYMO CMS Install Successfully !!!');
    }

    protected function createAdminUser()
    {
        $this->user['name'] = $this->ask('Full Name?');
        $this->user['email'] = $this->ask('Email?');
        $this->user['password'] = $this->ask('Password?');

        $validator = Validator::make($this->user, [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|max:32|min:6'
        ], [], [
            'name' => trans('mymo_core::app.name'),
            'email' => trans('mymo_core::app.email'),
            'password' => trans('mymo_core::app.password')
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
<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Models\User;
use Illuminate\Support\Facades\Validator;

class MakeAdminCommand extends Command
{
    protected $signature = 'juzaweb:make-admin';

    protected $user;

    public function handle()
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
            exit(1);
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

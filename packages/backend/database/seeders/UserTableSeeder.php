<?php

namespace Juzaweb\Backend\Database\Seeders;

use Illuminate\Database\Seeder;
use Juzaweb\Models\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::factory(1)->create([
            'is_admin' => 1
        ]);

        User::factory(5)->create();
    }
}

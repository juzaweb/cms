<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            GenresSeeder::class,
            MoviesSeeder::class,
            StarsSeeder::class,
        ]);
        
    }
}

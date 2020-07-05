<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            GenresSeeder::class,
            CountriesSeeder::class,
            StarsSeeder::class,
            TagsSeeder::class,
            MoviesSeeder::class,
            PostsSeeder::class,
            CommentsSeeder::class,
        ]);
        
    }
}

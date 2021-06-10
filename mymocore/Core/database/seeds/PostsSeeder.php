<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 10) as $row) {
            $title = $faker->sentence(10);
            DB::table('posts')->insert([
                'title' => $title,
                'content' => $faker->sentence(50),
                'status' => 1,
                'slug' => \Illuminate\Support\Str::slug($title),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

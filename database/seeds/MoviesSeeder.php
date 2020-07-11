<?php

use Illuminate\Database\Seeder;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 25) as $row) {
            $name = $faker->name;
            DB::table('movies')->insert([
                'name' => $name,
                'other_name' => $faker->name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    
        foreach (range(1, 25) as $row) {
            $name = $faker->name;
            DB::table('movies')->insert([
                'name' => $name,
                'other_name' => $faker->name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'tv_series' => 1,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

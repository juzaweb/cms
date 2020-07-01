<?php

use Illuminate\Database\Seeder;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 50) as $row) {
            $name = $faker->name;
            DB::table('movies')->insert([
                'name' => $name,
                'name_en' => $faker->name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'status' => 1,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

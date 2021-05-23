<?php

use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 20) as $row) {
            $name = $faker->name;
            DB::table('genres')->insert([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'status' => 1,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class StarsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 20) as $row) {
            $name = $faker->name;
            DB::table('stars')->insert([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'status' => 1,
                'type' => 'actor',
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    
        foreach (range(1, 5) as $row) {
            $name = $faker->name;
            DB::table('stars')->insert([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'status' => 1,
                'type' => 'director',
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    
        foreach (range(1, 5) as $row) {
            $name = $faker->name;
            DB::table('stars')->insert([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'status' => 1,
                'type' => 'writer',
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

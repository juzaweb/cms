<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 20) as $row) {
            $name = $faker->name;
            DB::table('tags')->insert([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

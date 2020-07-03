<?php

use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 10) as $row) {
            DB::table('comments')->insert([
                'user_id' => 1,
                'subject_id' => 1,
                'type' => 1,
                'content' => $faker->sentence(10),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    
        foreach (range(1, 10) as $row) {
            DB::table('comments')->insert([
                'user_id' => 1,
                'subject_id' => 1,
                'type' => 2,
                'content' => $faker->sentence(10),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }
}

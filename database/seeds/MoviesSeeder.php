<?php

use Illuminate\Database\Seeder;

class MoviesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 25) as $row) {
            $name = $faker->name;
            $genres = \App\Models\Genres::where('status', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
            
            $countries = \App\Models\Countries::where('status', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
            
            $tags = \App\Models\Tags::inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
            $type = \App\Models\Types::inRandomOrder()->first();
            
            DB::table('movies')->insert([
                'name' => $name,
                'other_name' => $faker->name,
                'type_id' => $type->id,
                'genres' => implode(',', $genres),
                'countries' => implode(',', $countries),
                'tags' => implode(',', $tags),
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
            $genres = \App\Models\Genres::where('status', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
    
            $countries = \App\Models\Countries::where('status', '=', 1)
                ->inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
    
            $tags = \App\Models\Tags::inRandomOrder()
                ->limit(3)
                ->pluck('id')
                ->toArray();
    
            $type = \App\Models\Types::inRandomOrder()->first();
            
            DB::table('movies')->insert([
                'name' => $name,
                'other_name' => $faker->name,
                'type_id' => $type->id,
                'genres' => implode(',', $genres),
                'countries' => implode(',', $countries),
                'tags' => implode(',', $tags),
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

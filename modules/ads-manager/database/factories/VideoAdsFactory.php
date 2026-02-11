<?php

namespace Juzaweb\Modules\AdsManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\AdsManagement\Models\VideoAds;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Juzaweb\Modules\AdsManagement\Models\VideoAds>
 */
class VideoAdsFactory extends Factory
{
    protected $model = VideoAds::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Dummy video URL
            'position' => 'video_mid', // Dummy position
            'offset' => $this->faker->numberBetween(0, 300),
            'active' => $this->faker->boolean(80),
            'views' => $this->faker->numberBetween(100, 10000),
            'click' => $this->faker->numberBetween(10, 1000),
            'options' => [],
        ];
    }
}

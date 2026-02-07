<?php

namespace Juzaweb\Modules\AdsManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Juzaweb\Modules\AdsManagement\Enums\BannerAdsType;
use Juzaweb\Modules\AdsManagement\Models\BannerAds;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Juzaweb\Modules\AdsManagement\Models\BannerAds>
 */
class BannerAdsFactory extends Factory
{
    protected $model = BannerAds::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradients = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
            'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
        ];

        $titles = [
            'Gaming Sale - Up to 70% Off',
            'New Releases This Week',
            'Premium Gaming Gear',
            'Limited Time Offer',
            'Special Gaming Bundle',
            'Top Rated Games',
            'Exclusive Gaming Deals',
            'Hot Gaming News',
        ];

        $gradient = $this->faker->randomElement($gradients);
        $title = $this->faker->randomElement($titles);

        return [
            'name' => $this->faker->unique()->words(3, true) . ' Banner',
            'body' => $this->generateBannerHTML($gradient, $title),
            'active' => $this->faker->boolean(80), // 80% chance active
            'url' => $this->faker->url(),
            'type' => BannerAdsType::TYPE_HTML,
            'views' => $this->faker->numberBetween(1000, 100000),
            'click' => $this->faker->numberBetween(100, 10000),
        ];
    }

    /**
     * Generate beautiful HTML for banner ad
     */
    protected function generateBannerHTML(string $gradient, string $title): string
    {
        return sprintf(
            '<div style="background: %s; padding: 20px; border-radius: 8px; text-align: center; font-family: Arial, sans-serif; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                <div style="color: white; font-size: 24px; font-weight: bold; margin-bottom: 10px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">%s</div>
                <div style="color: #f0f0f0; font-size: 14px; margin-bottom: 15px;">Amazing deals on gaming products! Limited time offer 🎮</div>
                <div style="background: white; color: #333; padding: 10px 24px; display: inline-block; border-radius: 25px; font-weight: bold; cursor: pointer; transition: transform 0.2s;">
                    Shop Now →
                </div>
            </div>',
            $gradient,
            $title
        );
    }

    /**
     * Indicate that the banner ad is a simple image banner
     */
    public function imageBanner(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => BannerAdsType::TYPE_BANNER,
            'body' => 'uploads/banners/' . $this->faker->word() . '.jpg',
        ]);
    }

    /**
     * Indicate that the banner ad is inactive
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Set specific gradient color
     */
    public function gradient(string $gradient): static
    {
        return $this->state(function (array $attributes) use ($gradient) {
            $title = explode('</div>', $attributes['body'])[0];
            $title = strip_tags($title);

            return [
                'body' => $this->generateBannerHTML($gradient, $title),
            ];
        });
    }
}

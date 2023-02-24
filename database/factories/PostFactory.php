<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\Farmer;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => User::factory()->farmer()->has(Farmer::factory()),
            'crop_id' => Crop::getRandomCrop(),
            'author_type' => User::class,
            'title' => fake()->sentence(5),
            'caption' => fake()->text(),
            'payment_option' => fake()->randomElement(['Cash', 'Gcash']),
            'delivery_option' => fake()->randomElement(['Pick-up', 'Third-Party', 'Farmer']),
            'unit' => 'kg',
            'pricing_type' => 'straight',
            'status' => fake()->randomElement(['Available', 'Sold']),
            'min_order' => fake()->numberBetween(10, 999),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            $post->prices()->create([
                'value' => fake()->randomNumber(3),
                'stocks' => 1000,
            ]);
            $post->attachments()->create([
                'source' => 'https://via.placeholder.com/300/09f/fff.png',
                'type' => 'url'
            ]);
        });
    }
}

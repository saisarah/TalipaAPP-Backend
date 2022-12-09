<?php

namespace Database\Factories;

use App\Models\Farmer;
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
            'author_id' => Farmer::inRandomOrder()->first()->user_id,
            'author_type' => Farmer::class,
            'caption' => fake()->text(),
            'payment_option' => fake()->randomElement(['Cash', 'Gcash']),
            'delivery_option' => fake()->randomElement(['Pick-up', 'Third-Party', 'Farmer']),
            'unit' => 'kg',
            'pricing_type' => 'straight',
            'status' => fake()->randomElement(['Available', 'Sold']),
            'min_order' => fake()->numberBetween(10, 999),


        ];
    }
}

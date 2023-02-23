<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farmer>
 */
class FarmerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->farmer(),
            'farm_area' => fake()->randomNumber(2),
            'farm_type' => fake()->randomElement(['Irrigated', 'Rainfed Upland', 'Rainfed Lowland']),
            'ownership_type' => fake()->randomElement(['Registered Owner', 'Tenant', 'Lessee']),
            'document_type' => 'N/A',
            'document' => 'N/A',
        ];
    }
}

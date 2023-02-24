<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demand>
 */
class DemandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vendor_id' => Vendor::factory(),
            'budget' => rand(1000, 10000),
            'quantity' =>  rand(500, 2000),
            'description' => fake()->text(),
            'crop_id' => Crop::getRandomCrop()
        ];
    }
}

<?php

namespace Database\Factories;

use App\Services\AddressService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{

    public function __construct(
        private AddressService $address
    ) {
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $region = $this->address->getRegions()->random();
        $province = $this->address->getProvinces($region->region_name)->random();
        $municipality = $this->address->getCities($region->region_name, $province->province_name)->random();
        $barangay = $this->address->getBarangays($region->region_name, $province->province_name, $municipality->city_name)->random();

        return [
            'region' => $region->region_name,
            'province' => $province->province_name,
            'municipality' => $municipality->city_name,
            'barangay' => $barangay,
            'street' => fake()->streetName(),
            'house_number' => fake()->streetAddress(),
        ];
    }
}

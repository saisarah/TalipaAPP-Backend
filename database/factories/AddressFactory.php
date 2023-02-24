<?php

namespace Database\Factories;

use App\Services\Address\Address;
use App\Services\Address\AddressService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $address = app()->make(AddressService::class);
        $region = $address->getRegions()->random();
        $province = $address->getProvinces($region->region_name)->random();
        $municipality = $address->getCities($region->region_name, $province->province_name)->random();
        $barangay = $address->getBarangays($region->region_name, $province->province_name, $municipality->city_name)->random();

        return [
            'region' => $region->region_name,
            'province' => $province->province_name,
            'municipality' => $municipality->city_name,
            'barangay' => $barangay->brgy_name,
            'street' => fake()->streetName(),
            'house_number' => fake()->streetAddress(),
        ];
    }
}

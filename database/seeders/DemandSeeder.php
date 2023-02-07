<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Demand;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Demand::create([
            'vendor_id' => Vendor::inRandomOrder()->first()->user_id,
            'budget' => 100000,
            'quantity' =>  1000,  
            'description' => fake()->text(),
            'crop_id' => Crop::inRandomOrder()->first()->id
        ]);
        Demand::create([
            'vendor_id' => Vendor::inRandomOrder()->first()->user_id,
            'budget' => 100000,
            'quantity' =>  1000,  
            'description' => fake()->text(),
            'crop_id' => Crop::inRandomOrder()->first()->id
        ]);
        Demand::create([
            'vendor_id' => Vendor::inRandomOrder()->first()->user_id,
            'budget' => 100000,
            'quantity' =>  1000,  
            'description' => fake()->text(),
            'crop_id' => Crop::inRandomOrder()->first()->id
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Farmer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Crop;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crops = Crop::all();
        Farmer::factory()
            ->count(100)
            ->hasAttached($crops)
            ->create();
        
    }
}

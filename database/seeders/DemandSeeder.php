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
        $vendors = Vendor::all();

        Demand::factory()
            ->recycle($vendors)
            ->count(100)
            ->create();
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\FarmerGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Populate Crops table
        $this->call(CropSeeder::class);

        //Generate 100 random farmer accounts
        $this->call(FarmerSeeder::class);

        //Generate 100 posts for random farmer accounts
        $this->call(PostSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(FarmerGroupSeeder::class);
    }
}

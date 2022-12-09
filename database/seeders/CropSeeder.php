<?php

namespace Database\Seeders;

use App\Models\Crop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Crop::create(['name' => 'Mango', 'image' => 'none']);
        Crop::create(['name' => 'Banana', 'image' => 'none']);
        Crop::create(['name' => 'Onion', 'image' => 'none']);
        Crop::create(['name' => 'Pineapple', 'image' => 'none']);
        Crop::create(['name' => 'Garlic', 'image' => 'none']);
        Crop::create(['name' => 'Eggplant', 'image' => 'none']);
        Crop::create(['name' => 'Cabbage', 'image' => 'none']);
    }
}

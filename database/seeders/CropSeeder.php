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
        Crop::insert([
            ['name' => 'Mango', 'image' => 'none'],
            ['name' => 'Banana', 'image' => 'none'],
            ['name' => 'Onion', 'image' => 'none'],
            ['name' => 'Pineapple', 'image' => 'none'],
            ['name' => 'Garlic', 'image' => 'none'],
            ['name' => 'Eggplant', 'image' => 'none'],
            ['name' => 'Cabbage', 'image' => 'none'],
        ]);
    }
}

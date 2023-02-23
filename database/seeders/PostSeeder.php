<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $farmers = Farmer::all();

        Post::factory()
            ->count(100)
            ->recycle($farmers)
            ->create();
    }
}

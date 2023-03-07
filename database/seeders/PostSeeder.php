<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Post;
use App\Models\User;
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
        $farmers = User::where('user_type', User::TYPE_FARMER)->get();

        Post::factory()
            ->count(25)
            ->recycle($farmers)
            ->create();
    }
}

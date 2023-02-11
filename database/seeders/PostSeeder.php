<?php

namespace Database\Seeders;

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
        Post::factory()
            ->hasAttachments(3, [
                'source' => 'https://via.placeholder.com/300/09f/fff.png',
                'type' => 'url'
            ])
            ->count(100)
            ->create();
    }
}

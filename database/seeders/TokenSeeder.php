<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("
            INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
                (1, 'App\\\Models\\\User', 1, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:109.0) Gecko/20100101 Firefox/111.0', 'dcc9c4bf8cb15086bc31ecef62f79e6ac20c73c1748356bf3446eade13bed496', '[\"*\"]', NULL, NULL, '2023-03-20 06:25:00', '2023-03-20 06:25:00'),
                (2, 'App\\\Models\\\User', 2, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:109.0) Gecko/20100101 Firefox/111.0', '4ae78e5f69b726d6cca7f1acab1b323f4cd708b17d277ca90877bbffb0e99719', '[\"*\"]', NULL, NULL, '2023-03-20 06:26:52', '2023-03-20 06:26:52');
        ");
    }
}

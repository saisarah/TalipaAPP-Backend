<?php

namespace Database\Seeders;

use App\Models\PublicMarket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicMarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PublicMarket::create([
            'name' => 'De Leon Stall',
            'region' => 'NCR',
            'city' => 'Marikina City',

        ]);

        PublicMarket::create([
            'name' => 'Pasig City Mega Market',
            'region' => 'NCR',
            'city' => 'Pasig City',
            
        ]);

        PublicMarket::create([
            'name' => 'Agora Public Market',
            'region' => 'NCR',
            'city' => 'San Juan City',
            
        ]);

        PublicMarket::create([
            'name' => 'Langaray Public Market',
            'region' => 'NCR',
            'city' => 'Caloocan City',
            
        ]);

        PublicMarket::create([
            'name' => 'Malabon Central Market',
            'region' => 'NCR',
            'city' => 'Malabon City',
            
        ]);

        PublicMarket::create([
            'name' => 'Tanza Public Market',
            'region' => 'NCR',
            'city' => 'Navotas City',
            
        ]);

        PublicMarket::create([
            'name' => 'Gulayan Bayan Center Kadiwa',
            'region' => 'NCR',
            'city' => 'Valenzuela City',
            
        ]);

        PublicMarket::create([
            'name' => 'Almanza Public Market',
            'region' => 'NCR',
            'city' => 'Las Piñas City',
            
        ]);

        PublicMarket::create([
            'name' => 'Poblacion Public Market',
            'region' => 'NCR',
            'city' => 'Makati City',
            
        ]);

        PublicMarket::create([
            'name' => 'Southvile III Public Market',
            'region' => 'NCR',
            'city' => 'Muntinlupa City',
            
        ]);

        
    }
}

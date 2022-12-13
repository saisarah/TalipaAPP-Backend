<?php

namespace Database\Seeders;

use App\Models\FarmerGroup;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FarmerGroupSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FarmerGroup::create(['name' => 'Bonena Multi-Purpose Cooperative', 'Address' => 'Brgy. Curva, Bongabon, Nueva Ecija', 
        'group_description' => 'Bonena Multi Purpose Cooperative values long-term relationship with its member farmers, clients and employees. It is committed in uplifting the lives of every Filipino farmers by providing livelihood by means of high quality products at a competitive prices.', 
        'contact_no' => '+63 917 8350 338',
        'email' => 'admin@bonenacoop.com',
        'type' => 'Cooperative',
        'year_founded' => 'NA',
        'status' => 'Verified',
        'authorization' => 'NA']);



    }
}

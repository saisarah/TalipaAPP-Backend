<?php

namespace Database\Seeders;

use App\Models\Farmer;
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
        $farmers = Farmer::all();

        FarmerGroup::create([
            'name' => 'Bonena Multi-Purpose Cooperative',
            'Address' => 'Brgy. Curva, Bongabon, Nueva Ecija',
            'group_description' => 'Bonena Multi Purpose Cooperative values long-term relationship with its member farmers, clients and employees. It is committed in uplifting the lives of every Filipino farmers by providing livelihood by means of high quality products at a competitive prices.',
            'contact_no' => '+63 917 8350 338',
            'email' => 'admin@bonenacoop.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'KASAMNE',
            'Address' => 'Caballero, 3132 Palayan City',
            'group_description' => 'Katipunan ng mga samahang magsisibuyas ng Nueva Ecija            ',
            'contact_no' => '(044)-940-5512',
            'email' => 'NA',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Agrizkaya Cooperative Federation (AGCOFED) ',
            'Address' => 'National Highway, Bambang City, 3702 Nueva Vizcaya, Philippines',
            'group_description' => 'Training - Marketing - Financial Intermediation - Administrative Support.
            A Federation that caters the needs of Primary Coops and engaged in Organic Production and Marketing.',
            'contact_no' => '+63 926 574 5531',
            'email' => 'agrizkaya_fed@yahoo.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Kafdeco Kasibu Farmers Development Cooperative',
            'Address' => 'National Highway, Kasibu, 3703 Nueva Vizcaya, Philippines',
            'group_description' => 'Training - Marketing - Financial Intermediation - Administrative Support.
            A Federation that caters the needs of Primary Coops and engaged in Organic Production and Marketing.',
            'contact_no' => '+63 965 602 3011',
            'email' => 'kafdeco91@gmail.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Sentrong Pamilihan ng Produktong Agrikultura sa Quezon Federation (SPAQ) Inc',
            'Address' => 'Maharlika highway Brgy. Sampaloc 2, Sariaya Quezon',
            'group_description' => 'Training - Marketing - Financial Intermediation - Administrative Support.
            A Federation that caters the needs of Primary Coops and engaged in Organic Production and Marketing.',
            'contact_no' => '(042) 373 2992',
            'email' => 'sentrongpamilihan@yahoo.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);

        FarmerGroup::create([
            'name' => 'Bikolanas Agriculture Cooperative',
            'Address' => 'Block 11 Lot 50-51, Mahogany Street, Villa Karangahan Subdivision, San Felipe, Naga City, Naga City, Philippines',
            'group_description' => 'They started as a group of 37 women from Bicol unified by a common advocacy for entrepreneurship focused on green health technologies and promotion of best practices to help protect and preserve the environment such as organic farming and sustainable waste management.',
            'contact_no' => '+63 968 852 0193',
            'email' => 'bikolanasagriculture@yahoo.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Talisayon Multi-Purpose Cooperative Tamuco',
            'Address' => 'De Lara St, 4602 Talisay, Philippines',
            'group_description' => 'Talisayon Multi-Purpose Cooperative is an Agricultural Based Cooperative reaching out the community by providing financial services and livelihood skills training.
            Motivated to empower Women, Youth, Farmers /Fisher folks, Small Scale Entrepreneurs, and IPs',
            'contact_no' => '6050038',
            'email' => 'tamuco_869@yahoo.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Agri-Preneur Farmers and Producers Association, Inc',
            'Address' => 'Libmanan, Camarines Sur ',
            'group_description' => 'AgripreneurPH is a collection of farms and agricultural ventures. It owns multi-hectare farms in Southern Tagalog region at the same time it partners with private farms in the country for short-term to longterm farm ventures.',
            'contact_no' => '+63 948 921 7159',
            'email' => 'robertbuayaban@gmail.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Greeners cooperative',
            'Address' => 'GIFTA/Purok 2, Bambang, Philippines, 37 02',
            'group_description' => 'AgripreneurPH is a collection of farms and agricultural ventures. It owns multi-hectare farms in Southern Tagalog region at the same time it partners with private farms in the country for short-term to longterm farm ventures.',
            'contact_no' => '+63 948 921 7159',
            'email' => 'greenersvizcaya@yahoo.com',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
        FarmerGroup::create([
            'name' => 'Federation of Free Farmers',
            'Address' => '30-F, 6th Avenue, Brgy. Socorro, Cubao, Quezon City, Philippines.',
            'group_description' => 'The Federation of free farmers (FFF) is currently one of the largest and most effective non-governmental organizations of rural workers in the Philippines. It was organized in 1953 by a group of Catholic laymen soon after the break-up of the Communist-led revolutionary movement in the country during the term of President Ramon Magsaysay.',
            'contact_no' => '(+632) 8-647 1451',
            'email' => 'freefarm@freefarm.org',
            'type' => 'Cooperative',
            'year_founded' => 'NA',
            'status' => 'Verified',
            'authorization' => 'NA',
            'farmer_id' => $farmers->random()->user_id,
        ]);
    }
}

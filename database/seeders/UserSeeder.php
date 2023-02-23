<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->farmer()
            ->has(Farmer::factory())
            ->create([
                'firstname' => env('USER_FIRSTNAME', 'John'),
                'lastname' => env('USER_LASTNAME', 'Doe'),
                'email' => env('USER_EMAIL', 'john@doe.com'),
                'contact_number' => env('USER_PHONE', '9123456789'),
            ]);

        User::factory()
            ->vendor()
            ->has(Vendor::factory())
            ->create([
                'firstname' => 'Sarah',
                'lastname' => 'Oben',
                'email' => 'sarah@email.com',
                'contact_number' => '9876543210',
            ]);
    }
}

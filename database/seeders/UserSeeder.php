<?php

namespace Database\Seeders;

use App\Models\Farmer;
use App\Models\Message;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Crop;
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
        $crops = Crop::all();
        $farmer = User::factory()
            ->farmer()
            ->has(Farmer::factory()->hasAttached($crops))
            ->create([
                'firstname' => env('USER_FIRSTNAME', 'John'),
                'lastname' => env('USER_LASTNAME', 'Doe'),
                'email' => env('USER_EMAIL', 'john@doe.com'),
                'contact_number' => env('USER_PHONE', '9123456789'),
            ]);

        $vendor = User::factory()
            ->vendor()
            ->has(Vendor::factory()->hasAttached($crops))
            ->create([
                'firstname' => 'Sarah',
                'lastname' => 'Oben',
                'email' => 'sarah@email.com',
                'contact_number' => '9876543210',
            ]);

        Message::create([
            'sender_id' => $farmer->id,
            'receiver_id' => $vendor->id,
            'content' => 'Hello'
        ]);

        Message::create([
            'sender_id' => $vendor->id,
            'receiver_id' => $farmer->id,
            'content' => 'Hi'
        ]);

        $farmer->activateWallet()->deposit(10000);
        $vendor->activateWallet()->deposit(10000);
    }
}

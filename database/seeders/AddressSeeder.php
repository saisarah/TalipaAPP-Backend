<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Address\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(function(User $user) {
            $user->address()->update(Address::factory()->make()->toArray());
        });
    }
}

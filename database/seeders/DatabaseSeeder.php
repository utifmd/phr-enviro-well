<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $strEmail = 'mk.utif.dori@pertamina.com';
        User::factory()->create([
            'username' => explode("@", $strEmail)[0],
            'password' => Hash::make('12121212'),
            'email' => $strEmail,
        ]);
    }
}

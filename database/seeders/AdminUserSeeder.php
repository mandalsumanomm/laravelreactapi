<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Remove any existing user with the same email
        //User::where('email', 'suman@gmail.com')->forceDelete();

        // Create new admin credentials
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Replace with a strong password
            'role_as' => 1, // Admin role
        ]);
    }
}

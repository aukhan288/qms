<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch the 'admin' role
        $adminRole = DB::table('roles')->where('name', 'admin')->first();

        // Create an admin user and assign the 'admin' role
        User::create([
            'name' => 'Asadullah khan',  // Admin user name
            'email' => 'aukhan288@gmail.com',  // Admin email
            'org' => 'Lamtans ltd',  // Admin email
            'street' => '1023 Stockport Rd',  // Admin email
            'district' => 'Levenshulme',  // Admin email
            'city' => 'Manchester',  // Admin email
            'postal_code' => 'M19 2TB',  // Admin email
            'password' => Hash::make('Admin12#'), // Admin password (change as needed)
            'role_id' => $adminRole->id,  // Assign the admin role
        ]);
    }
}

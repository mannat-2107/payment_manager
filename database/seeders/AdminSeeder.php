<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@payment.com'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('super-admin');
    }
}
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
        // Admin
        User::firstOrCreate(
            ['email' => 'ardiansyahdzan@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 1,
                'is_active' => 1,
            ]
        );

        // Writer
        User::firstOrCreate(
            ['email' => 'writer@example.com'],
            [
                'name' => 'Demo Writer',
                'password' => Hash::make('password'),
                'role' => 0,
                'is_active' => 1,
            ]
        );
    }
}

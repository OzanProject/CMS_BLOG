<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Theme::create([
            'name' => 'Default Theme',
            'path' => 'default',
            'is_active' => true,
        ]);

        \App\Models\Theme::create([
            'name' => 'Modern Theme',
            'path' => 'modern',
            'is_active' => false,
        ]);
    }
}

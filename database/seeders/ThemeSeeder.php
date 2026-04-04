<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Theme::updateOrCreate(
            ['path' => 'default'],
            ['name' => 'Default Theme', 'is_active' => true]
        );

        Theme::updateOrCreate(
            ['path' => 'modern'],
            ['name' => 'Modern Theme (React)', 'is_active' => false]
        );
    }
}

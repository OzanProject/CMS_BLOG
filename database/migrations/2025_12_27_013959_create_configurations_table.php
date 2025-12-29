<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        $defaults = [
            'site_name' => 'My CMS Blog',
            'site_description' => 'A modern blog built with Laravel 12 & Tailwind',
            'site_logo' => null,
            'site_favicon' => null,
            'footer_text' => '© 2025 All Rights Reserved.',
            'social_facebook' => '#',
            'social_twitter' => '#',
            'social_instagram' => '#',
        ];

        foreach ($defaults as $key => $value) {
            \Illuminate\Support\Facades\DB::table('configurations')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};

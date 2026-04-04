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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path'); // views/themes/{path}
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // Insert default themes
        \Illuminate\Support\Facades\DB::table('themes')->insert([
            ['name' => 'Default Theme', 'path' => 'default', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Modern Theme (React)', 'path' => 'modern', 'is_active' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};

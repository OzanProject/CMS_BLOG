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
        Schema::table('articles', function (Blueprint $table) {
            // Change keywords to TEXT (supports unlimited length vs VARCHAR 255)
            $table->text('keywords')->nullable()->change();
            // Also expand meta_description for safety
            $table->text('meta_description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('keywords', 255)->nullable()->change();
            $table->string('meta_description', 255)->nullable()->change();
        });
    }
};

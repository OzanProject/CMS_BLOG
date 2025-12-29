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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Organization

            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // For summary cards & meta description fallback
            $table->longText('content'); // Rich Text
            $table->string('featured_image')->nullable();
            
            // Status & Publishing
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            
            // Analytics
            $table->unsignedBigInteger('views')->default(0);
            
            // SEO / AdSense Optimization
            $table->string('meta_title')->nullable(); // Custom Title Tag
            $table->string('meta_description')->nullable(); // Custom Meta Description
            $table->string('keywords')->nullable(); // Helper for tags/keywords
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

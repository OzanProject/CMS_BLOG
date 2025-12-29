<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class IndonesianContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        
        // Truncate tables to ensure fresh seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Article::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure there is at least one user
        if (User::count() == 0) {
            User::factory()->create([
                'name' => 'Admin Indonesia',
                'email' => 'admin@indo.com',
                'password' => bcrypt('password'),
            ]);
        }
        $users = User::all();

        // 1. Create Indonesian Categories
        $categoriesNames = [
            'Teknologi', 'Kesehatan', 'Gaya Hidup', 'Kuliner', 
            'Pariwisata', 'Otomotif', 'Berita Terkini', 'Olahraga'
        ];

        foreach ($categoriesNames as $catName) {
            Category::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
                'description' => $faker->sentence(10),
            ]);
        }

        $categories = Category::all();

        // 2. Create Indonesian Articles
        for ($i = 0; $i < 30; $i++) {
            $title = $faker->sentence(rand(5, 8)); // Generate title first

            Article::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(5), // Ensure unique slug
                'excerpt' => $faker->paragraph(2),
                'content' => collect($faker->paragraphs(rand(5, 10)))->map(fn($p) => "<p>$p</p>")->implode(''),
                'status' => 'published',
                'published_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'views' => 0,
                'is_featured' => $faker->boolean(15),
                'is_trending' => $faker->boolean(10),
                'meta_title' => $title,
                'meta_description' => $faker->sentence(10),
                'keywords' => implode(', ', $faker->words(5)),
            ]);
        }
    }
}

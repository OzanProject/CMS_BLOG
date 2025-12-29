<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<p>Ini adalah halaman Tentang Kami. Silakan ubah konten ini di Admin Panel.</p>',
                'meta_title' => 'Tentang Kami - Blog',
                'meta_description' => 'Tentang Kami',
                'status' => 1,
            ],
            [
                'title' => 'Hubungi Kami',
                'slug' => 'hubungi-kami',
                'content' => '<p>Hubungi kami melalui email atau telepon. Silakan ubah konten ini.</p>',
                'meta_title' => 'Hubungi Kami - Blog',
                'meta_description' => 'Halaman Kontak',
                'status' => 1,
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => '<p>Halaman Kebijakan Privasi standar.</p>',
                'meta_title' => 'Kebijakan Privasi - Blog',
                'meta_description' => 'Kebijakan Privasi',
                'status' => 1,
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '<p>Halaman Penafian (Disclaimer).</p>',
                'meta_title' => 'Disclaimer - Blog',
                'meta_description' => 'Penafian',
                'status' => 1,
            ],
        ];

        foreach ($pages as $page) {
            \App\Models\Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
